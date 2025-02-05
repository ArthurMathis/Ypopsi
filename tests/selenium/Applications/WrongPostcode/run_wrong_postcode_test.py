import os
import sys

sys.path.append(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
sys.path.append(os.path.dirname(os.path.abspath(__file__)))

from InscriptCandidatesWrongPostcode1 import InscriptCandidatesWrongPostcode1
from InscriptCandidatesWrongPostcode2 import InscriptCandidatesWrongPostcode2
from InscriptCandidatesWrongPostcode3 import InscriptCandidatesWrongPostcode3

VIOLET = '\033[38;2;128;0;128m'
GREEN = '\033[92m'
RESET = '\033[0m'

def RunWrongPostcodeTest():
    print(VIOLET + "===== Procédure de test de l'inscription des codes postaux =====" + RESET)
    
    test = InscriptCandidatesWrongPostcode1()
    test.run()
    
    test = InscriptCandidatesWrongPostcode2()
    test.run()
    
    test = InscriptCandidatesWrongPostcode3()
    test.run()
    
    print(GREEN + "Procédure Validée" + RESET)

if __name__ == "__main__":
    RunWrongPostcodeTest()