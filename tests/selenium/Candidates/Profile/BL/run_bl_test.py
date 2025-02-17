import os
import sys

current_dir = os.path.dirname(os.path.abspath(__file__))

bl_dir         = current_dir
profile_dir    = os.path.dirname(bl_dir)
candidates_dir = os.path.dirname(profile_dir)
parent_dir     = os.path.dirname(candidates_dir)

sys.path.append(current_dir)
sys.path.append(parent_dir)

from define import write

from InscriptBLa import InscriptBLa
from InscriptBLab import InscriptBLab
from InscriptBLabc import InscriptBLabc
from InscriptBLac import InscriptBLac
from InscriptBLb import InscriptBLb
from InscriptBLbc import InscriptBLbc
from InscriptBLc import InscriptBLc

VIOLET = '\033[38;2;128;0;128m'
GREEN = '\033[92m'
RESET = '\033[0m'

def RunBLTest():
    write("Procédure de test d'inscritpion d'une BL", VIOLET, "subtitle")
    
    test = InscriptBLa()
    test.run()
    
    test = InscriptBLab()
    test.run()
    
    test = InscriptBLabc()
    test.run()
    
    test = InscriptBLac()
    test.run()
    
    test = InscriptBLb()
    test.run()
    
    test = InscriptBLbc()
    test.run()
    
    test = InscriptBLc()
    test.run()
    
    write("Procédure Validée", GREEN, "valid")
    
if __name__ == "__main__":
    RunBLTest()