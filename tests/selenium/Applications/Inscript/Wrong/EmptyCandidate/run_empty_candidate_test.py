import os
import sys

current_dir = os.path.dirname(os.path.abspath(__file__))
sys.path.append(current_dir)

from InscriptCandidatesEmptyName import InscriptCandidatesEmptyName
from InscriptCandidatesEmptyFirstname import InscriptCandidatesEmptyFirstname
from InscriptCandidatesEmptyAddress import InscriptCandidatesEmptyAddress
from InscriptCandidatesEmptyCity import InscriptCandidatesEmptyCity
from InscriptCandidatesEmptyPostcode import InscriptCandidatesEmptyPostcode

VIOLET = '\033[38;2;128;0;128m'
GREEN = '\033[92m'
RESET = '\033[0m'

def RunEmptyCandidateTest():
    print(VIOLET + "===== Procédure de test avec champs manquants =====" + RESET)
    
    test = InscriptCandidatesEmptyName()
    test.run() 
    
    test = InscriptCandidatesEmptyFirstname()
    test.run()
    
    test = InscriptCandidatesEmptyAddress()
    test.run()
    
    test = InscriptCandidatesEmptyCity()
    test.run()
    
    test = InscriptCandidatesEmptyPostcode()
    test.run()
    
    print(GREEN + "Procédure Validée" + RESET)
    
if __name__ == "__main__":
    RunEmptyCandidateTest()