
import denominations 

def createCvs(path, max):
     with open(path, "w") as _file:
        for i in range(1,max+1):
            line = f"{i},{denominations.getName()},{i}\n"
            _file.write(line)