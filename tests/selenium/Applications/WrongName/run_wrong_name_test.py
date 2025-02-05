import os
import sys

sys.path.append(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
sys.path.append(os.path.dirname(os.path.abspath(__file__)))

from InscriptCandidatesWrongName1 import InscriptCandidatesWrongName1
from InscriptCandidatesWrongName2 import InscriptCandidatesWrongName2
from InscriptCandidatesWrongName3 import InscriptCandidatesWrongName3

VIOLET = '\033[38;2;128;0;128m'
GREEN = '\033[92m'
RESET = '\033[0m'

def RunWrongNameTest():
    print(VIOLET + "===== Procédure de test de l'intégrité des noms =====" + RESET)
    
    test = InscriptCandidatesWrongName1()
    test.run()

    test = InscriptCandidatesWrongName2()
    test.run()
    
    test = InscriptCandidatesWrongName3()
    test.run()
    
    print(GREEN + "Procédure Validée" + RESET)

if __name__ == "__main__":
    RunWrongNameTest()