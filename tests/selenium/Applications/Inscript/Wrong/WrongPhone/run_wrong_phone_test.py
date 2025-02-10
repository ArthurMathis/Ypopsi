import os
import sys

current_dir = os.path.dirname(os.path.abspath(__file__))
sys.path.append(current_dir)

from InscriptCandidatesWrongPhone1 import InscriptCandidatesWrongPhone1
from InscriptCandidatesWrongPhone2 import InscriptCandidatesWrongPhone2

VIOLET = '\033[38;2;128;0;128m'
GREEN = '\033[92m'
RESET = '\033[0m'

def RunWrongPhoneTest():
    print(VIOLET + "===== Procédure de test de l'intégrité des téléphones =====" + RESET)
    
    test = InscriptCandidatesWrongPhone1()
    test.run()
    
    test = InscriptCandidatesWrongPhone2()
    test.run()
    
    print(GREEN + "Procédure Validée" + RESET)
    
if __name__ == "__main__":
    RunWrongPhoneTest()