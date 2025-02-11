import os
import sys

current_dir = os.path.dirname(os.path.abspath(__file__))

wrong_postcode_dir = current_dir
wrong_dir          = os.path.dirname(wrong_postcode_dir)
inscript_dir       = os.path.dirname(wrong_dir)
applications_dir   = os.path.dirname(inscript_dir)
parent_dir         = os.path.dirname(applications_dir)

sys.path.append(current_dir)
sys.path.append(parent_dir)

from define import write

from InscriptCandidatesWrongPostcode1 import InscriptCandidatesWrongPostcode1
from InscriptCandidatesWrongPostcode2 import InscriptCandidatesWrongPostcode2
from InscriptCandidatesWrongPostcode3 import InscriptCandidatesWrongPostcode3

VIOLET = '\033[38;2;128;0;128m'
GREEN = '\033[92m'
RESET = '\033[0m'

def RunWrongPostcodeTest():
    write("Procédure de test de l'inscription des codes postaux", VIOLET, "subtitle")
    
    test = InscriptCandidatesWrongPostcode1()
    test.run()
    
    test = InscriptCandidatesWrongPostcode2()
    test.run()
    
    test = InscriptCandidatesWrongPostcode3()
    test.run()
    
    write("Procédure Validée", GREEN, "valid")

if __name__ == "__main__":
    RunWrongPostcodeTest()