import os
import sys

current_dir = os.path.dirname(os.path.abspath(__file__))

wrong_email_dir  = current_dir
wrong_dir        = os.path.dirname(wrong_email_dir)
inscript_dir     = os.path.dirname(wrong_dir)
applications_dir = os.path.dirname(inscript_dir)
parent_dir       = os.path.dirname(applications_dir)

sys.path.append(current_dir)
sys.path.append(parent_dir)

from define import write

from InscriptCandidatesWrongEmail1 import InscriptCandidatesWrongEmail1
from InscriptCandidatesWrongEmail2 import InscriptCandidatesWrongEmail2
from InscriptCandidatesWrongEmail3 import InscriptCandidatesWrongEmail3

VIOLET = '\033[38;2;128;0;128m'
GREEN = '\033[92m'
RESET = '\033[0m'

def RunWrongEmailTest():
    write("Procédure de test de l'intégrité des emails", VIOLET, "subtitle")
    
    test = InscriptCandidatesWrongEmail1()
    test.run()
    
    test = InscriptCandidatesWrongEmail2()
    test.run()
    
    test = InscriptCandidatesWrongEmail3()
    test.run()
    
    write("Procédure Validée", GREEN, "valid")

if __name__ == "__main__":
    RunWrongEmailTest()