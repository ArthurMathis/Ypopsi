import os
import sys

sys.path.append(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
sys.path.append(os.path.dirname(os.path.abspath(__file__)))

from InscriptCandidatesWrongFirstname1 import InscriptCandidatesWrongFirstname1
from InscriptCandidatesWrongFirstname2 import InscriptCandidatesWrongFirstname2
from InscriptCandidatesWrongFirstname3 import InscriptCandidatesWrongFirstname3

VIOLET = '\033[38;2;128;0;128m'
GREEN = '\033[92m'
RESET = '\033[0m'

def RunWrongFirstnameTest():
    print(VIOLET + "===== Procédure de test de l'intégrité des prénoms =====" + RESET)
    
    test = InscriptCandidatesWrongFirstname1()
    test.run()

    test = InscriptCandidatesWrongFirstname2()
    test.run()
    
    test = InscriptCandidatesWrongFirstname3()
    test.run()
    
    print(GREEN + "Procédure Validée" + RESET)

if __name__ == "__main__":
    RunWrongFirstnameTest()