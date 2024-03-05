import numpy as np
import cv2 as cv
import datetime
import imageio
import os
import threading

class videoStream2():
    def __init__(self, video_path='http://192.168.1.2:49347/videostream.cgi?user=admin&pwd=888888',folder_images = "C:/xampp/htdocs/image",folder_gifs = "C:/xampp/htdocs/uploads",target_fps = 3,camera_name = "Camera_2"):
        self.videoPath = video_path
        self.cap = cv.VideoCapture(video_path)
        self.folder_images = folder_images
        self.folder_gifs = folder_gifs
        self.target_fps = target_fps
        self.frame_skip = int(self.cap.get(cv.CAP_PROP_FPS) / target_fps)

        # Lists to store frames before saving the snapshot
        self.buffer_gif_frames = []
        
        if not self.cap.isOpened():
            print("Cannot open camera")
            exit()

        self.ret, self.first_frame = self.cap.read()
        if not self.ret:
            print("Failed to read the first frame.")
            self.cap.release()
            exit()
            
        # Lists
        self.garbage_list = []
        self.human_list = []
        self.garbage_time_interval = 60
        self.human_time_interval = 1

        # Save
        self.buffer_size = 10
        self.buffer = [None] * self.buffer_size
        self.buffer_center = 5
        self.buffer_gif_frames = []
        self.rgb_gifs = []

        # Camera
        self.camera_name = camera_name

        # Human detector using HOG
        self.hog = cv.HOGDescriptor()
        self.hog.setSVMDetector(cv.HOGDescriptor_getDefaultPeopleDetector())

    def save_images(self,snapshot_images, full_path_images, current_frame):
        cv.imwrite(full_path_images, current_frame)
        print(f"Saved images : {snapshot_images}")

    def save_gif(self,snapshot_gifs, full_path_gifs, buffer_gif_frames, rgb_gifs):
        rgb_gifs = [cv.cvtColor(frame, cv.COLOR_BGR2RGB) for frame in buffer_gif_frames[-5:]]
        imageio.mimsave(full_path_gifs, rgb_gifs, fps=self.target_fps)
        print(f"Saved gifs : {snapshot_gifs}")

    def cameraPrediction(self):
        while True:
            ret, current_frame = self.cap.read()

            if not ret:
                break
            
            self.buffer[self.buffer_center] = current_frame
            
            for _ in range(self.frame_skip - 1):
                self.cap.read()
                
            self.buffer_gif_frames.append(current_frame)
            
            if len(self.buffer_gif_frames) >= self.buffer_size:
                del self.buffer_gif_frames[0]

            if len(self.rgb_gifs) >= self.buffer_size:
                del self.rgb_gifs[0]

            # Human Detection
            human_rects, _ = self.hog.detectMultiScale(current_frame)
            scale_factor = 0.8
            for (x, y, w, h) in human_rects:
                w = int(w * scale_factor)
                h = int(h * scale_factor)
                human_centroid = (x + w // 2, y + h // 2)
                human_timestamp = datetime.datetime.now()
                cv.circle(current_frame, human_centroid, 1, (0, 0, 255), -1)
                cv.rectangle(current_frame, (x, y), (x + w, y + h), (255, 0, 0), 2)
                
                # Human Tracking
                if self.human_list:
                    for human in self.human_list:
                        distance = np.linalg.norm(np.array(human_centroid) - np.array(human['human_centroid']))
                        if distance < 100:
                            human['human_centroid'] = human_centroid
                            human['human_timestamp'] = human_timestamp
                            cv.circle(current_frame, human_centroid, 1, (0, 0, 255), -1)
                            human_name = human['human_name']
                            cv.putText(current_frame, f'{human_name}', (x, y),
                                        cv.FONT_HERSHEY_SIMPLEX, 0.4, (0, 0, 255), 1, cv.LINE_AA)
                            break
                    else:
                        self.human_list.append
                        ({'human_name': f'Human_{len(self.human_list) + 1}',
                                        'human_centroid': human_centroid,
                                        'human_timestamp': human_timestamp})
                else:
                    self.human_list.append
                    ({'human_name': 'Human_1',
                                    'human_centroid': human_centroid,
                                    'human_timestamp': human_timestamp})
                    
                current_time = datetime.datetime.now()
                self.human_list = [human for human in self.human_list if 
                            (current_time - human['human_timestamp']).total_seconds() <= self.human_time_interval]
                
            # Foreground Detection
            diff = cv.absdiff(self.first_frame, current_frame)
            gray = cv.cvtColor(diff, cv.COLOR_BGR2GRAY)
            gray = cv.GaussianBlur(gray, (3, 3), 1)
            _, threshold = cv.threshold(gray, 30, 255, cv.THRESH_BINARY)
            contours, _ = cv.findContours(threshold, cv.RETR_EXTERNAL, cv.CHAIN_APPROX_SIMPLE)

            for cnt in contours:
                if cv.contourArea(cnt) > 10 and cv.contourArea(cnt) < 200:
                    x, y, w, h = cv.boundingRect(cnt)
                    garbage_centroid = (x + w // 2, y + h // 2)
                    garbage_timestamp = datetime.datetime.now()
                    cv.rectangle(current_frame, (x, y), (x + w, y + h), (0, 255, 0), 2)
                
                    # Garbage Tracking
                    if self.garbage_list:
                        for garbage in self.garbage_list:
                            distance = np.linalg.norm(np.array(garbage_centroid) - np.array(garbage['garbage_centroid']))
                            if distance < 50:
                                garbage['garbage_centroid'] = garbage_centroid
                                garbage['garbage_timestamp'] = garbage_timestamp
                                cv.circle(current_frame, garbage_centroid, 1, (0, 0, 255), -1)
                                garbage_name = garbage['garbage_name']
                                cv.putText(current_frame, f'{garbage_name}', (x, y - 10),
                                        cv.FONT_HERSHEY_SIMPLEX, 0.4, (0, 0, 255), 1, cv.LINE_AA)
                                break
                        else:
                            self.garbage_list.append
                            ({'garbage_name': f'Garbage_{len(self.garbage_list) + 1}',
                                            'garbage_centroid': garbage_centroid,
                                            'garbage_timestamp': garbage_timestamp})
                            if self.human_list:
                                for human in self.human_list:
                                    for (x, y, w, h) in human_rects:
                                        if (x, y, w, h) in human_rects:
                                            for garbage in self.garbage_list:
                                                distance = np.linalg.norm(np.array(garbage['garbage_centroid']) - np.array(human['human_centroid']))
                                                if distance < 100:                  
                                                    current_time = datetime.datetime.now()
                                                    snapshot_images = f"{self.camera_name}_{current_time.year}_{current_time.month:02d}_{current_time.day:02d}_{current_time.hour:02d}_{current_time.minute:02d}_{current_time.second:02d}.png"
                                                    full_path_images = os.path.join(self.folder_images, snapshot_images)
                                                    images_thread = threading.Thread(target=self.save_images, args=(snapshot_images, full_path_images))
                                                    images_thread.start()
                                                    snapshot_gifs = f"{self.camera_name}_{current_time.year}_{current_time.month:02d}_{current_time.day:02d}_{current_time.hour:02d}_{current_time.minute:02d}_{current_time.second:02d}.gif"
                                                    full_path_gifs = os.path.join(self.folder_gifs, snapshot_gifs)
                                                    gifs_thread = threading.Thread(target=self.save_gif, args=(snapshot_gifs, full_path_gifs, self.buffer_gif_frames, self.rgb_gifs))
                                                    gifs_thread.start()
                                            break
                                    else:
                                        continue
                                    break
                            else:
                                continue                                                  
                    else:
                        self.garbage_list.append
                        ({'garbage_name': 'Garbage_1',
                                        'garbage_centroid': garbage_centroid,
                                        'garbage_timestamp': garbage_timestamp,
                                        'garbage_snapshot': False})
                        if self.human_list:
                            for human in self.human_list:
                                for (x, y, w, h) in human_rects:
                                    if (x, y, w, h) in human_rects:
                                        for garbage in self.garbage_list:
                                            distance = np.linalg.norm(np.array(garbage['garbage_centroid']) - np.array(human['human_centroid']))
                                            if distance < 100:                  
                                                current_time = datetime.datetime.now()
                                                snapshot_images = f"{self.camera_name}_{current_time.year}_{current_time.month:02d}_{current_time.day:02d}_{current_time.hour:02d}_{current_time.minute:02d}_{current_time.second:02d}.png"
                                                full_path_images = os.path.join(self.folder_images, snapshot_images)
                                                images_thread = threading.Thread(target=self.save_images, args=(snapshot_images, full_path_images))
                                                images_thread.start()
                                                snapshot_gifs = f"{self.camera_name}_{current_time.year}_{current_time.month:02d}_{current_time.day:02d}_{current_time.hour:02d}_{current_time.minute:02d}_{current_time.second:02d}.gif"
                                                full_path_gifs = os.path.join(self.folder_gifs, snapshot_gifs)
                                                gifs_thread = threading.Thread(target=self.save_gif, args=(snapshot_gifs, full_path_gifs, self.buffer_gif_frames, self.rgb_gifs))
                                                gifs_thread.start()
                                        break
                                else:
                                    continue
                                break
                        else:
                            continue 

                    self.garbage_list = [garbage for garbage in self.garbage_list if
                                    (garbage_timestamp - garbage['garbage_timestamp']).total_seconds() <= self.garbage_time_interval]
                    
                    # Return the frame
                    return current_frame
                
    def __del__(self):
        self.cap.release()
        cv.destroyAllWindows()

    def getFrame(self):
        return self.cameraPrediction()
    

