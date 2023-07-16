import tkinter
import customtkinter
from PIL import Image, ImageTk  # <- import PIL for the images
import os
from tut4 import *

PATH = os.path.dirname(os.path.realpath(__file__))

customtkinter.set_appearance_mode("Light")  # Modes: "System" (standard), "Dark", "Light"
customtkinter.set_default_color_theme("dark-blue")  # Themes: "blue" (standard), "green", "dark-blue"

app = customtkinter.CTk()  # create CTk window like you do with the Tk window (you can also use normal tkinter.Tk window)
app.geometry("500x260")
app.title("CustomTkinter example_button_images.py")


def button():
    start()


# load images as PhotoImage
image_size = 50


camera_image = ImageTk.PhotoImage(Image.open(PATH + '/test_images/camera.png').resize((image_size, image_size), Image.ANTIALIAS))
fssm_image = ImageTk.PhotoImage(Image.open(PATH + "/test_images/fssm.png").resize((90, 90)))
norsys_image = ImageTk.PhotoImage(Image.open(PATH + "/test_images/norsys.png").resize((90, 90)))


app.grid_rowconfigure(1, weight=2)
app.grid_columnconfigure(1, weight=2, minsize=200)
app.resizable(False,False)



label_1 = customtkinter.CTkLabel(image = fssm_image)
label_1.grid(row=0, column=2,  pady=20, sticky="nsew")
#label_1.pack()

label_2 = customtkinter.CTkLabel(image = norsys_image)
label_2.grid(row=0, column=0,  pady=20, sticky="nsew")
#label_2.pack()

button_5 = customtkinter.CTkButton(master=app, image=camera_image, text=None, width=130, height=70, border_width=3,
                                   corner_radius=10, compound="bottom", border_color="#D35B58", fg_color=("gray84", "gray25"), hover_color="#C77C78",
                                   command=button)
button_5.grid(row=1, column=1, padx=20, pady=20)

app.mainloop()
