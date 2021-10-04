from datetime import date 
import random as rand
_NAMES = ["Sofia",
"Valentina",
"Regina",
"Maria Jose",
"Ximena",
"Camila",
"Maria Fernanda",
"Valeria", 
"Victoria", 
"Renata",
"Santiago",
"Mateo", 
"Sebastian", 
"Leonardo",
"Matias", 
"Emiliano",
"Diego", 
"Daniel", 
"Miguel Angel", 
"Alexander"]
_LAST_NAME =["Hernandez",
"Vazquez",
"Zarate",
"Perez",
"Cuapio",
"Rodriguez",
"Xicotecantl",
"Xolocotzi",
"Flores",
"Cuamatzi"]

_CURPS = ["MAHJ280603MSPRRV09", "ROVI490617HSPDSS05",
"PERC561125MSPRMT03",
"TOHA530902HSPRRN07"]
_NSS =["07957595548", "07957595542","07957595541", "07957595540","07957595541"]

def getRandInt(max):
    i = rand.randint(0, max)
    if i== max:
        i-= 1
    return i
def getNss():
    i = getRandInt(len(_NSS))
    return _NSS[i]
def getCurp():
    i = getRandInt(len(_CURPS))
    return _CURPS[i]
def createName()-> str:
    lasName = _LAST_NAME[getRandInt(len(_LAST_NAME))]
    middleName = _LAST_NAME[getRandInt(len(_LAST_NAME))]
    name = _NAMES[getRandInt(len(_NAMES))]
    return f"{name} {middleName} {lasName}"
def getFolio() -> int:
    return  rand.randint(0, 11)
def createCsvLine(i) -> str:
    line = f"{i},{createName()},{getCurp()},{rand.randint(1, 9)},{getNss()},{date.today()}\n"
    return line    
    

def createCsv(path, max):
    with open(path, "w") as _file:
        for i in range(1, max+1):
            _file.write(createCsvLine(i))