import os
import sys

current_dir = os.path.dirname(os.path.abspath(__file__))

empty_candidates_dir = current_dir
wrong_dir            = os.path.dirname(empty_candidates_dir)
inscript_dir         = os.path.dirname(wrong_dir)
applications_dir     = os.path.dirname(inscript_dir)
parent_dir           = os.path.dirname(applications_dir)

sys.path.append(current_dir)
sys.path.append(parent_dir)

from define import write

from InscriptCandidatesEmptyName import InscriptCandidatesEmptyName
from InscriptCandidatesEmptyFirstname import InscriptCandidatesEmptyFirstname
from InscriptCandidatesEmptyAddress import InscriptCandidatesEmptyAddress
from InscriptCandidatesEmptyCity import InscriptCandidatesEmptyCity
from InscriptCandidatesEmptyPostcode import InscriptCandidatesEmptyPostcode

VIOLET = '\033[38;2;128;0;128m'
GREEN = '\033[92m'
RESET = '\033[0m'

def RunEmptyCandidateTest():
    write("Procédure de test avec champs manquants", VIOLET, "subtitle")
    
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
    
    write("Procédure Validée", GREEN, "valid")
    
if __name__ == "__main__":
    RunEmptyCandidateTest()