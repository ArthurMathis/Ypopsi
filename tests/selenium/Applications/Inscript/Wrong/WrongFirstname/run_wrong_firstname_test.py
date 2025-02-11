import os
import sys

current_dir = os.path.dirname(os.path.abspath(__file__))

wrong_firstname_dir = current_dir
wrong_dir           = os.path.dirname(wrong_firstname_dir)
inscript_dir        = os.path.dirname(wrong_dir)
applications_dir    = os.path.dirname(inscript_dir)
parent_dir          = os.path.dirname(applications_dir)

sys.path.append(current_dir)
sys.path.append(parent_dir)

from define import write

from InscriptCandidatesWrongFirstname1 import InscriptCandidatesWrongFirstname1
from InscriptCandidatesWrongFirstname2 import InscriptCandidatesWrongFirstname2
from InscriptCandidatesWrongFirstname3 import InscriptCandidatesWrongFirstname3

VIOLET = '\033[38;2;128;0;128m'
GREEN = '\033[92m'
RESET = '\033[0m'

def RunWrongFirstnameTest():
    write("Procédure de test de l'intégrité des prénoms", VIOLET, "subtitle")
    
    test = InscriptCandidatesWrongFirstname1()
    test.run()

    test = InscriptCandidatesWrongFirstname2()
    test.run()
    
    test = InscriptCandidatesWrongFirstname3()
    test.run()
    
    write("Procédure Validée", GREEN, "valid")

if __name__ == "__main__":
    RunWrongFirstnameTest()