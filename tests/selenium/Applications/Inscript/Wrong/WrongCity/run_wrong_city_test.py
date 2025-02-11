import os
import sys

current_dir = os.path.dirname(os.path.abspath(__file__))

wrong_city_dir   = current_dir
wrong_dir        = os.path.dirname(wrong_city_dir)
inscript_dir     = os.path.dirname(wrong_dir)
applications_dir = os.path.dirname(inscript_dir)
parent_dir       = os.path.dirname(applications_dir)

sys.path.append(current_dir)
sys.path.append(parent_dir)

from define import write

from InscriptCandidatesWrongCity1 import InscriptCandidatesWrongCity1
from InscriptCandidatesWrongCity2 import InscriptCandidatesWrongCity2
from InscriptCandidatesWrongCity3 import InscriptCandidatesWrongCity3
from InscriptCandidatesWrongCity4 import InscriptCandidatesWrongCity4

VIOLET = '\033[38;2;128;0;128m'
GREEN = '\033[92m'
RESET = '\033[0m'

def RunWrongCityTest():
    write("Procédure de test de l'intégrité des villes", VIOLET, "subtitle")
    
    test = InscriptCandidatesWrongCity1()
    test.run()
    
    test = InscriptCandidatesWrongCity2()
    test.run()
    
    test = InscriptCandidatesWrongCity3()
    test.run()
    
    test = InscriptCandidatesWrongCity4()
    test.run()
    
    write("Procédure Validée", GREEN, "valid")

if __name__ == "__main__":
    RunWrongCityTest()