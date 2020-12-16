import threading
#from Itead_PN532 import Itead_PN532
from Rfid import Rfid
from mfrc522 import SimpleMFRC522
from gi.repository import GLib


class UidReader:
    
    def __init__(self, func):
        self.func = func
        
    def readUid(self):
        #uid = rd.readCard()
        #uid = input()
        rf = Rfid()
        uid = rf.read_uid()
        GLib.idle_add(self.func, uid)
      

          
    
    
