import os
import sys

sys.path.append(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
sys.path.append(os.path.dirname(os.path.abspath(__file__)))

from InscriptCandidatesWrongEmail1 import InscriptCandidatesWrongEmail1
from InscriptCandidatesWrongEmail2 import InscriptCandidatesWrongEmail2
from InscriptCandidatesWrongEmail3 import InscriptCandidatesWrongEmail3

VIOLET = '\033[38;2;128;0;128m'
GREEN = '\033[92m'
RESET = '\033[0m'

def RunWrongEmailTest():
    print(VIOLET + "===== Procédure de test de l'intégrité des emails =====" + RESET)
    
    test = InscriptCandidatesWrongEmail1()
    test.run()
    
    test = InscriptCandidatesWrongEmail2()
    test.run()
    
    test = InscriptCandidatesWrongEmail3()
    test.run()
    
    print(GREEN + "Procédure Validée" + RESET)

if __name__ == "__main__":
    RunWrongEmailTest()