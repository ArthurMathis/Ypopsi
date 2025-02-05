import os
import sys

sys.path.append(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
sys.path.append(os.path.dirname(os.path.abspath(__file__)))

from InscriptCandidatesWrongCity1 import InscriptCandidatesWrongCity1
from InscriptCandidatesWrongCity2 import InscriptCandidatesWrongCity2
from InscriptCandidatesWrongCity3 import InscriptCandidatesWrongCity3
from InscriptCandidatesWrongCity4 import InscriptCandidatesWrongCity4

VIOLET = '\033[38;2;128;0;128m'
GREEN = '\033[92m'
RESET = '\033[0m'

def RunWrongCityTest():
    print(VIOLET + "===== Procédure de test de l'intégrité des villes =====" + RESET)
    
    test = InscriptCandidatesWrongCity1()
    test.run()
    
    test = InscriptCandidatesWrongCity2()
    test.run()
    
    test = InscriptCandidatesWrongCity3()
    test.run()
    
    test = InscriptCandidatesWrongCity4()
    test.run()
    
    print(GREEN + "Procédure Validée" + RESET)

if __name__ == "__main__":
    RunWrongCityTest()