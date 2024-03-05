from fastapi import FastAPI, Request
from fastapi.middleware.cors import CORSMiddleware
from fastapi.openapi.utils import get_openapi
from fastapi.responses import JSONResponse
from videoStream import videoStream
import cv2
import time

# Run the server by typing this command in the terminal:
# python -m uvicorn camera:app --reload

from starlette.responses import StreamingResponse
origins = [
    'http://localhost'
]
port = 8000

description = """
Feed from camera
"""

tags_metadata = [
    {
        "name": "CameraFeed",
        "description": "Camera Feed"
    }
]
app = FastAPI(
    openapi_tags=tags_metadata,
    title="CamFeed",
    description=description,
    summary="Camera feed",
    version="0.0.1",
    contact={
        "name": "RMUTT Computer Engineering"
    },
    license_info={
        "name": "Apache 2.0",
        "url": "https://www.apache.org/licenses/LICENSE-2.0.html",
    },
    
)

app.add_middleware(
    CORSMiddleware,
    allow_origins=origins,
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"]
)

cam_current_frame = None

camera1 = videoStream(
    video_path = "http://192.168.1.2:49347/videostream.cgi?user=admin&pwd=888888",
    folder_images = "C:/xampp/htdocs/image",
    folder_gifs = "C:/xampp/htdocs/uploads",
    target_fps = 30,
    camera_name = "Camera_1"
)
# camera2 = videoStream(
#     video_path = "http://192.168.1.2:39190/videostream.cgi?user=admin&pwd=888888",
#     folder_images = "C:/xampp/htdocs/image",
#     folder_gifs = "C:/xampp/htdocs/uploads",
#     target_fps = 30,
#     camera_name = "Camera_2"
# )


@app.get("/stream/video", tags=["StreamingResponse"], description="Video feed of the camera")
async def get_video_stream():
    def generate():
        while True:
            try:
                frame = camera1.getFrame()
                (flag, encodedImage) = cv2.imencode(".jpg", frame)
                if not flag:
                    continue
            except:
                continue

            # yield the output frame in the byte format
            yield (b'--frame\r\n' b'Content-Type: image/jpeg\r\n\r\n' +
                bytearray(encodedImage) + b'\r\n')
            
            time.sleep(0.1)
            
            
    return StreamingResponse(generate(), media_type="multipart/x-mixed-replace; boundary=frame")

# @app.get("/stream/video2", tags=["StreamingResponse"], description="Video feed of the camera")
# async def get_video_stream():
#     def generate():
#         while True:
#             frame = camera2.getFrame()
#             (flag, encodedImage) = cv2.imencode(".jpg", frame)
#             if not flag:
#                 continue
#             # yield the output frame in the byte format
#             yield (b'--frame\r\n' b'Content-Type: image/jpeg\r\n\r\n' +
#                 bytearray(encodedImage) + b'\r\n')
            
#             time.sleep(0.1)
            
            
#     return StreamingResponse(generate(), media_type="multipart/x-mixed-replace; boundary=frame")



if __name__ == "__main__":
    from uvicorn import run
    # -m uvicorn camera:app --reload
    run(app, host="127.0.0.1", port=8000)

