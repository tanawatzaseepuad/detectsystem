import cv2
import numpy as np
import cv2 as cv
import datetime
import requests
import base64

video_path = "http://192.168.1.2:49347/videostream.cgi?user=admin&pwd=888888"
cap = cv.VideoCapture(video_path)
folder_images = "C:/Users/Sangchai/OneDrive/Desktop/Project/Project/image"
folder_gifs = "C:/Users/Sangchai/OneDrive/Desktop/Project/Project/uploads"

target_fps = 30
frame_skip = int(cap.get(cv.CAP_PROP_FPS) / target_fps)

if not cap.isOpened():
    print("Cannot open camera")
    exit()

ret, first_frame = cap.read()
if not ret:
    print("Failed to read the first frame.")
    cap.release()
    exit()  

# Lists
garbage_list = []
human_list = []
garbage_time_interval = 1
human_time_interval = 0.1

# Save
buffer_size = 10
buffer = [None] * buffer_size
buffer_center = 5

# Camera
camera_name1 = "Camera1"
camera_name2 = "Camera2"

# Human detector using HOG
hog = cv.HOGDescriptor()
hog.setSVMDetector(cv.HOGDescriptor_getDefaultPeopleDetector())

# Lists to store frames before saving the snapshot
buffer_gif_frames = []

# Flag to control the loop
running = True

while running:
    # Capture frame-by-frame
    ret, current_frame = cap.read()
    
    if not ret:
        break

    # Convert frame to JPEG format
    _, jpeg_frame = cv2.imencode('.jpg', current_frame)
    encoded_frame = base64.b64encode(jpeg_frame).decode('utf-8')

    # Send frame to PHP script
    # response = requests.post('http://localhost/register/detection_admin.php', data={'video_data': encoded_frame})
    response = requests.post('http://localhost/register/detection_admin.php', data={'video_data': encoded_frame})
    if response.status_code != 200:
        print('Failed to send frame to PHP script')

    # Wait for the specified frame rate
    cv2.waitKey(1000 // target_fps)
    
    buffer[buffer_center] = current_frame
    
    # Skip frames according to frame_skip
    for _ in range(frame_skip - 1):
        cap.read()
        
    buffer_gif_frames.append(current_frame)

    # Human Detection
    human, _ = hog.detectMultiScale(current_frame)
    scale_factor = 0.8
    for (x, y, w, h) in human:
        w = int(w * scale_factor)
        h = int(h * scale_factor)
        human_centroid = (x + w // 2, y + h // 2)
        human_timestamp = datetime.datetime.now()
        cv.circle(current_frame, human_centroid, 1, (0, 0, 255), -1)
        cv.rectangle(current_frame, (x, y), (x + w, y + h), (255, 0, 0), 2)
        
        # Human Tracking
        if human_list:
            for human in human_list:
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
                human_list.append({'human_name': f'Human_{len(human_list) + 1}',
                                    'human_centroid': human_centroid,
                                    'human_timestamp': human_timestamp,
                                    'human_snapshot': False})
        else:
            human_list.append({'human_name': 'Human_1',
                                'human_centroid': human_centroid,
                                'human_timestamp': human_timestamp,
                                'human_snapshot': False})
            
    current_time = datetime.datetime.now()
    human_list = [human for human in human_list if 
                  (current_time - human['human_timestamp']).total_seconds() <= human_time_interval]


    # Foreground Detection
    diff = cv.absdiff(first_frame, current_frame)
    gray = cv.cvtColor(diff, cv.COLOR_BGR2GRAY)
    _, threshold = cv.threshold(gray, 30, 255, cv.THRESH_BINARY)
    contours, _ = cv.findContours(threshold, cv.RETR_EXTERNAL, cv.CHAIN_APPROX_SIMPLE)
    
    for cnt in contours:
        if cv.contourArea(cnt) > 10 and cv.contourArea(cnt) < 150:
            x, y, w, h = cv.boundingRect(cnt)
            garbage_centroid = (x + w // 2, y + h // 2)
            garbage_timestamp = datetime.datetime.now()
            cv.rectangle(current_frame, (x, y), (x + w, y + h), (0, 255, 0), 2)
        
            # Garbage Tracking
            if garbage_list:
                for garbage in garbage_list:
                    distance = np.linalg.norm(np.array(garbage_centroid) - np.array(garbage['garbage_centroid']))
                    if distance < 30:
                        garbage['garbage_centroid'] = garbage_centroid
                        garbage['garbage_timestamp'] = garbage_timestamp
                        cv.circle(current_frame, garbage_centroid, 1, (0, 0, 255), -1)
                        garbage_name = garbage['garbage_name']
                        cv.putText(current_frame, f'{garbage_name}', (x, y - 10),
                                   cv.FONT_HERSHEY_SIMPLEX, 0.4, (0, 0, 255), 1, cv.LINE_AA)
                        break
                else:
                    garbage_list.append({'garbage_name': f'Garbage_{len(garbage_list) + 1}',
                                         'garbage_centroid': garbage_centroid,
                                         'garbage_timestamp': garbage_timestamp,
                                         'garbage_snapshot': False})
            else:
                garbage_list.append({'garbage_name': 'Garbage_1',
                                     'garbage_centroid': garbage_centroid,
                                     'garbage_timestamp': garbage_timestamp,
                                     'garbage_snapshot': False})

            garbage_list = [garbage for garbage in garbage_list if
                            (garbage_timestamp - garbage['garbage_timestamp']).total_seconds() <= garbage_time_interval]


    # Check for keyboard input to exit the loop
    key = cv2.waitKey(1)
    if key == ord('q') or key == 27:
        running = False

cap.release()
cv.destroyAllWindows()