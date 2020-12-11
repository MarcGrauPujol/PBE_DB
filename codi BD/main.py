from __future__ import print_function
import pymysql


class DataBase:
    PBE=DSBM=TD=RP=PSAVC= False  #booleans utilitzarem mes tard
    def __init__(self):
        self.connection = pymysql.connect(  #connectem amb el servidor online
            host='sql7.freesqldatabase.com',
            user='sql7381488',
            password='1jj5niwCLx',
            db='sql7381488'
        )

        self.cursor = self.connection.cursor()

        print("Connexio establerta correctament!\n")

    def select_user(self,id):
        sql = 'SELECT * FROM estudiant WHERE id_estudiant = {}'.format(id)

        try:
            self.cursor.execute(sql)
            user=self.cursor.fetchone()
            print("Nom: "+user[0])
            print("Id: "+user[1])
            print ("Assignatures en curs:", end=' ')
            if(user[2]==1):
                print ('PBE',end=' ')
                self.PBE = True
            if(user[3]==1):
                print('DSBM',end=' ')
                self.DSBM = True
            if(user[4]==1):
                print('TD',end=' ')
                self.TD = True
            if(user[5]==1):
                print('RP',end=' ')
                self.RP = True
            if(user[6]==1):
                print('PSAVC',end=' ')
                self.PSAVC = True

        except Exception as e:
            raise 

    def select_notes(self,id):
        sql = 'SELECT * FROM notes WHERE id_estudiant = {}'.format(id)

        try:
            self.cursor.execute(sql)
            notes=self.cursor.fetchall()
            print("\n\nNotes assolides:")
            
            for nota in notes:
                print(nota[0],end=" ")
                print(nota[1],end=" ")
                print(nota[2])


        except Exception as e:
            raise

    def select_tasques(self):

        print("\nTasques a realitzar:")

        if(self.PBE):
            sql = "SELECT * FROM tasques WHERE assignatura = 'PBE'"
            database.print_tasques(sql)
        if(self.DSBM):
            sql = "SELECT * FROM tasques WHERE assignatura = 'DSBM'"
            database.print_tasques(sql)
        if(self.TD):
            sql = "SELECT * FROM tasques WHERE assignatura = 'TD'"
            database.print_tasques(sql)
        if(self.RP):
            sql = "SELECT * FROM tasques WHERE assignatura = 'RP'"
            database.print_tasques(sql)
        if(self.PSAVC):
            sql = "SELECT * FROM tasques WHERE assignatura = 'PSAVC'"
            database.print_tasques(sql)

    def print_tasques(self,str):
        sql = str

        try:
            self.cursor.execute(sql)
            tasques=self.cursor.fetchall()
            
            for tasca in tasques:
                print(tasca[0],end=" - ")
                print(tasca[1],end=" - ")
                print(tasca[2])

        except Exception as e:
            raise

    def select_horari(self):

        print("\nHorari docent:")

        if(self.PBE):
            sql = "SELECT * FROM timetables WHERE assignatura = 'PBE'"
            database.print_horaris(sql)
        if(self.DSBM):
            sql = "SELECT * FROM timetables WHERE assignatura = 'DSBM'"
            database.print_horaris(sql)
        if(self.TD):
            sql = "SELECT * FROM timetables WHERE assignatura = 'TD'"
            database.print_horaris(sql)
        if(self.RP):
            sql = "SELECT * FROM timetables WHERE assignatura = 'RP'"
            database.print_horaris(sql)
        if(self.PSAVC):
            sql = "SELECT * FROM timetables WHERE assignatura = 'PSAVC'"
            database.print_horaris(sql)

    def print_horaris(self,str):
        sql = str

        try:
            self.cursor.execute(sql)
            horaris=self.cursor.fetchall()
            
            for horari in horaris:
                print(horari[0],end=" - ")
                print(horari[1],end=" - ")
                print(horari[2],end=" - ")
                print(horari[3])

        except Exception as e:
            raise


database = DataBase()
print("Introdueix id estudiant:",end=" ")
id_actual=input()
database.select_user(id_actual) 
database.select_notes(id_actual)
database.select_tasques()
database.select_horari()

