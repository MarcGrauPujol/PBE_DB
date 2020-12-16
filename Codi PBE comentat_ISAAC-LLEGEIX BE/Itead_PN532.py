from pynfc import Nfc, Desfire, Timeout

class Itead_PN532:
    #constructor
    def __init__(self):
        self.n=Nfc("pn532_i2c://dev/i2c-1")
    def read_uid(self):
        for card in self.n.poll():
            try:
                uid=card.uid.decode().upper()
                return uid
            except Timeout:
                pass
