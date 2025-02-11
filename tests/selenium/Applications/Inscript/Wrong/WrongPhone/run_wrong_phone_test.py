import os
import sys

current_dir = os.path.dirname(os.path.abspath(__file__))

wrong_phone_dir  = current_dir
wrong_dir        = os.path.dirname(wrong_phone_dir)
inscript_dir     = os.path.dirname(wrong_dir)
applications_dir = os.path.dirname(inscript_dir)
parent_dir       = os.path.dirname(applications_dir)

sys.path.append(current_dir)
sys.path.append(parent_dir)

from define import write

from InscriptCandidatesWrongPhone1 import InscriptCandidatesWrongPhone1
from InscriptCandidatesWrongPhone2 import InscriptCandidatesWrongPhone2

VIOLET = '\033[38;2;128;0;128m'
GREEN = '\033[92m'
RESET = '\033[0m'

def RunWrongPhoneTest():
    write("Procédure de test de l'intégrité des téléphones", VIOLET, "subtitle")
    
    test = InscriptCandidatesWrongPhone1()
    test.run()
    
    test = InscriptCandidatesWrongPhone2()
    test.run()
    
    write("Procédure Validée", GREEN, "valid")
    
if __name__ == "__main__":
    RunWrongPhoneTest()