import RPi.GPIO as GPIO
from mfrc522 import SimpleMFRC522
GPIO.setwarnings(False);

class Rfid:
    # constructor
    def __init__(self):
        self.reader = SimpleMFRC522()
    # return uid in hexa str
    def read_uid(self):
        id = self.reader.read_id()
        return(hex(id).upper())
    
    

