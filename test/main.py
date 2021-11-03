import denominations
import workers
import departaments
import sys
workerPath = "worker.csv"
denominationsPath = "denomination.csv"
departamentPath = "departament.csv"
_MAX_ARGVS = 3

def getMaxOfVar(str) -> int:
    lines = str.split("=")
    try:
        max = int(lines[len(lines)-1])
    except Exception:
        max = 0
    return max
def main():
    maxDepartaments = 0
    maxWorkers = 0
    maxDenominations = 0
    _count = 0
    argvs = sys.argv[1::]
    if len(argvs) == _MAX_ARGVS:
       
        for i in range(_MAX_ARGVS):
            if "--departament=" in argvs[i]:
                maxDepartaments = getMaxOfVar(argvs[i])
                _count +=1
            elif "--denomination=" in argvs[i]:
                _count += 1
                maxDenominations = getMaxOfVar(argvs[i])
            elif "--worker=" in argvs[i]:
                maxWorkers = getMaxOfVar(argvs[i])
                _count += 1
                
        if maxWorkers == 0:
            print("el argumento workers es invalido")
            _count -= 1
        if maxDenominations == 0:
            print("el argumento denominations es invalido")
            _count -= 1
        if maxDepartaments  == 0:
            print("el argumento departaments es invalido")
            _count -= 1
        if _count == _MAX_ARGVS:
            print("creando archivo de razon social")
            denominations.createCvs(denominationsPath, maxDenominations)
            print("creando archivo de departaments")
            departaments.createCvs(departamentPath, maxDepartaments)
            print("creando archivo de trabajadores")
            workers.createCsv(workerPath, maxWorkers)

                
    else:
        print("argumentos invalidos")

main()