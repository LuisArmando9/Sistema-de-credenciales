
from random import randint as rint
_NAME = ["FAJKJALKF", "FAFAFAF", "LFAFAGAG",
"ADFAFAFAF", "FLÑAFKLÑAFKÑA", "AJKÑALFJQWRPM", "FAFAFAF",
"FLÑADAFAF", "FAFAFAFA", "FKLAÑGKAÑLKGA", "FJAKLFJLKAJF", "FAFAGAG"]
def getName() -> str:
    i = rint(0, len(_NAME))
    if i >= len(_NAME):
        i = len(_NAME) -1
    return _NAME[i]
def createCvs(path, max):
    with open(path, "w") as _file:
        for i in range(1,max+1):
            line = f"{i},{getName()}\n"
            _file.write(line)


