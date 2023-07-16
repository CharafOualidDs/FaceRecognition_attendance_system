import time

import cv2
import face_recognition
import os
from simple_facerec import SimpleFacerec
import numpy as np
from datetime import  datetime
import _mysql_connector
def start():
    sfr=SimpleFacerec()
    marrakeche= 'unknown'
    images = []
    classNames = []
    presentEmploye = []
    listClass = os.listdir(marrakeche)
    print(listClass)
    restore=sfr.getemploy()
    print(restore)
    print(len(restore))
    for image in restore :
        currentImg = cv2.imread(f'{image[1]}')
        images.append([currentImg,image[0]])
        classNames.append(image[2])

    imagesRGB=[]
    def findEncodings(images) :
        encodingsList = []

        for image in images :
            try:
                imagesRGB = cv2.cvtColor(image[0],cv2.COLOR_BGR2RGB)
                encode = face_recognition.face_encodings(imagesRGB)[0]
                encodingsList.append([encode,image[1]])
            except:
                continue
        return encodingsList
    encodingsKnown=findEncodings(images)
    print(encodingsKnown)
    t1=time.time()
    first=0

        #print(encodingsKnown)
    cap = cv2.VideoCapture(0)
    #global t1
    #global first
    while True:
         _, frame = cap.read()
         rgb_img = cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)
         faces_loc=face_recognition.face_locations(rgb_img)
         facencodings=face_recognition.face_encodings(rgb_img,faces_loc)

         for facencoding,face_loc in zip(facencodings,faces_loc) :
            top, right, bottom, left = face_loc[0], face_loc[1], face_loc[2], face_loc[3]

            matches=face_recognition.compare_faces([row[0] for row in encodingsKnown],facencoding)
            print(matches)
            face_distances = face_recognition.face_distance([row[0] for row in encodingsKnown], facencoding)
            best_match_index = np.argmin(face_distances)
            print(best_match_index)
            print(encodingsKnown[0][1])

                #roi_gray=gray[y:y+d,x:x+w]
            roi_color=frame[top:bottom,left:right]
                #img_roi=  'region.jpg'
                #cv2.imwrite(img_roi,roi_color)
            cv2.rectangle(frame,(left,top) , (right,bottom) , (255,0,0) , 1)
                #print(best_match_index)



                #t1=time.time()

                #best_match_index = np.argmin(face_distances)
            if matches[best_match_index] :
                    #count=sfr.Select_counter()
                   # name = classNames[best_match_index]
                   # print(name)
                    #print(encodingsKnown[index][1])
                    cv2.putText(frame, classNames[best_match_index], (left, top - 10), cv2.FONT_HERSHEY_DUPLEX, 1, (0, 0, 200), 2)
                    #cv2.putText(frame, classNames[best_match_index], (left, top - 10), cv2.FONT_HERSHEY_DUPLEX, 1, (0, 0, 200), 2)

                    sfr.insert_entrer(encodingsKnown[best_match_index][1])
            else :
                 cv2.putText(frame, 'Unknown', (left, top - 10), cv2.FONT_HERSHEY_DUPLEX, 1, (0, 0, 200), 2)
                 if time.time()-t1>20 or first==0:
                    path=sfr.insert_unknown('unknown')

                    cv2.imwrite(path, roi_color)
                    t1=time.time()
                    first=first+1

         cv2.imshow('frame', frame)
           # presentEmploye.append(name)

           # print(face_loc)
            #print(face_distances)
            #if matches[best_match_index] :q
               # print(matches[best_match_index])
            #  print("bonjour oualid")
         if cv2.waitKey(1)==ord('q') :
              break

    cap.release()
    cv2.destroyAllWindows()
    print(presentEmploye)


