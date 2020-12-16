from gi.repository import GLib
import requests
import threading

class ReadDataServer:
    #Passem el uid del usuari
    def __init__(self, uid):
        #URL a la que ens volem conectar
        self.url = "http://www.pbe41b.000webhostapp.com/index.php/"
        self.uid = uid
    
    #Adapta la query que enviarem
    #És el run del thread lector de data del server
    #Li passem la query (p.e. timetables?algo) 
    #i la funcio que s'executa quan tinguis la info en el nostre cas displayTable
    def sendQuery(self, query, func):
        txt=query.split("?");
        #Creem URL
        url = self.url + txt[0]+"?owner_id="+self.uid;
        #Mirem si existeix el algo
        if len(txt[1])>0:
            url=url+"&"+txt[1];
        #Data serà la info que rebem del seevidor
        #I traduim de jason a algo que entenguem
        #Data es nua matriu
        data = requests.get(url).json()
        #Displaiem table amb la nova data i de manera prioritaria 
        GLib.idle_add(func, data)
    
    #Fem com sendQuery pero per student_id i retornem el nom del usuari
    def getName(self, uid):
        self.uid = uid
        url = self.url + "estudiant?id_estudiant="+self.uid
        name = requests.get(url).json()
        return name[0][0]

    
