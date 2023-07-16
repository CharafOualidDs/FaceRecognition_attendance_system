import sys
import face_recognition
import cv2
import os
import glob
import numpy as np
from datetime import  datetime
import mysql.connector
from mysql.connector import Error
import time


class SimpleFacerec:
    def get_connection(self) :
        connection = mysql.connector.connect(host='localhost',
                                             database='charaf',
                                             user='root',
                                             password='')
        return connection
    def getemploy(self):
        connection = self.get_connection()
        cursor = connection.cursor()
        sql_query = "select id,imagename,nom from tblemployer where imagename != ''"
        cursor.execute(sql_query)
        return cursor.fetchall()
    def getunknown(self):
        connection = self.get_connection()
        cursor = connection.cursor()
        sql_query = "select id,imagename,nom from unknown"
        cursor.execute(sql_query)
        return cursor.fetchall()

    def Select_counter(self):
        try:
            connection = self.get_connection()
            cursor = connection.cursor()
            sql_query = """select count(nom) from tblemployer  """
            cursor.execute(sql_query)
            counts = cursor.fetchall()
            for count in counts :
                count = count[0]+1
            self.close_connection(connection)
        except (Exception, mysql.connector.Error) as error:
            print("Error while getting data", error)
        return count
    def insert_unknown(self,nom):
        try:
            countor=self.Select_counter()
            connection = self.get_connection()
            cursor = connection.cursor()
            img=hash(datetime.now())
            source="unknown/%d.jpg" %img
            sql_query = """insert into unknown(nom,imagename,source)Values(%s,%s,%s)"""
            path = r"C:\xamp\htdocs\charaf2\unknown\%d.jpg" %img
            cursor.execute(sql_query,(nom,path,source))
            connection.commit()
            self.close_connection(connection)
            return path

        except (Exception, mysql.connector.Error) as error:
            print("Error while getting data", error)

    def insert_entrer(self,id):
        try:
            # countor = self.Select_counter()
            connection = self.get_connection()
            cursor = connection.cursor()
            sql_query = """insert into entrer (employer)Values(%s)"""
            # path = r"C:\Users\LENOVO\Desktop\stage\imageSet\stage%d.jpg" % countor
            cursor.execute(sql_query, (id,))
            connection.commit()
            self.close_connection(connection)
        except (Exception, mysql.connector.Error) as error:
            print("Error while getting data", error)
    def close_connection(self,connection):
        if connection:
            connection.close()

    def __init__(self):
        self.known_face_encodings = []
        self.known_face_names = []

        # Resize frame for a faster speed
        self.frame_resizing = 0.5

    def load_encoding_images(self, images_path):
        """
        Load encoding images from path
        :param images_path:
        :return:
        """
        # Load Images
        images_path = glob.glob(os.path.join(images_path, "*.*"))

        print("{} encoding images found.".format(len(images_path)))

        # Store image encoding and names
        for img_path in images_path:
            img = cv2.imread(img_path)
            rgb_img = cv2.cvtColor(img, cv2.COLOR_BGR2RGB)

            # Get the filename only from the initial file path.
            basename = os.path.basename(img_path)
            (filename, ext) = os.path.splitext(basename)
            # Get encoding
            img_encoding = face_recognition.face_encodings(rgb_img)[0]

            # Store file name and file encoding
            self.known_face_encodings.append(img_encoding)
            self.known_face_names.append(filename)
        print("Encoding images loaded")

    def detect_known_faces(self, frame):
        small_frame = cv2.resize(frame, (0, 0), fx=self.frame_resizing, fy=self.frame_resizing)
        # Find all the faces and face encodings in the current frame of video
        # Convert the image from BGR color (which OpenCV uses) to RGB color (which face_recognition uses)
        rgb_small_frame = cv2.cvtColor(small_frame, cv2.COLOR_BGR2RGB)
        face_locations = face_recognition.face_locations(rgb_small_frame)
        face_encodings = face_recognition.face_encodings(rgb_small_frame, face_locations)

        face_names = []
        for face_encoding in face_encodings:
            # See if the face is a match for the known face(s)
            matches = face_recognition.compare_faces(self.known_face_encodings, face_encoding)
            name = "unknown"



            # if cursor.rowcount==1 :
                   # break




            if False in matches:
                self.insert_unknown(name)

            # # If a match was found in known_face_encodings, just use the first one.
            # if True in matches:
            #     first_match_index = matches.index(True)
            #     name = known_face_names[first_match_index]

            # Or instead, use the known face with the smallest distance to the new face
            face_distances = face_recognition.face_distance(self.known_face_encodings, face_encoding)
            best_match_index = np.argmin(face_distances)
            if matches[best_match_index]:
                name = self.known_face_names[best_match_index]

            face_names.append(name)



        # Convert to numpy array to adjust coordinates with frame resizing quickly
        face_locations = np.array(face_locations)
        face_locations = face_locations / self.frame_resizing
        return face_locations.astype(int), face_names
    def markAttendance(self,name):
        with open('attendenceCSV.csv','r+') as f :
            myDataList=f.readline()
            nameList=[]
            #print(nameList)
            for line in myDataList :
                entry = line.split(',')
                nameList.append(entry[0])
            if name not in nameList:
                now=datetime.now()
                dtString=now.strftime("%H:%M:%S")
                f.writelines(f'\n{name},{dtString}')


