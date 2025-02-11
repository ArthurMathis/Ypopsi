import os
import sys

current_dir = os.path.dirname(os.path.abspath(__file__))

wrong_name_dir = current_dir
wrong_dir            = os.path.dirname(wrong_name_dir)
inscript_dir         = os.path.dirname(wrong_dir)
applications_dir     = os.path.dirname(inscript_dir)
parent_dir           = os.path.dirname(applications_dir)

sys.path.append(current_dir)
sys.path.append(parent_dir)

from define import write

from InscriptCandidatesWrongName1 import InscriptCandidatesWrongName1
from InscriptCandidatesWrongName2 import InscriptCandidatesWrongName2
from InscriptCandidatesWrongName3 import InscriptCandidatesWrongName3

VIOLET = '\033[38;2;128;0;128m'
GREEN = '\033[92m'
RESET = '\033[0m'

def RunWrongNameTest():
    write("Procédure de test de l'intégrité des noms", VIOLET, "subtitle")
    
    test = InscriptCandidatesWrongName1()
    test.run()

    test = InscriptCandidatesWrongName2()
    test.run()
    
    test = InscriptCandidatesWrongName3()
    test.run()
    
    write("Procédure Validée", GREEN, "valid")

if __name__ == "__main__":
    RunWrongNameTest()