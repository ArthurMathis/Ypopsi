import os
import sys

sys.path.append(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
sys.path.append(os.path.dirname(os.path.abspath(__file__)))

from InscriptCandidatesWithHelp import InscriptCandidatesWithHelp
from InscriptCandidatesWithHelpQualification import InscriptCandidatesWithHelpQualification
from InscriptCandidatesWithHelpQualifications import InscriptCandidatesWithHelpQualifications
from InscriptCandidatesWithHelps import InscriptCandidatesWithHelps
from InscriptCandidatesWithHelpsQualification import InscriptCandidatesWithHelpsQualification
from InscriptCandidatesWithHelpsQualifications import InscriptCandidatesWithHelpsQualifications
from InscriptCandidatesWithHelpsVisit import InscriptCandidatesWithHelpsVisit
from InscriptCandidatesWithHelpsVisitQualification import InscriptCandidatesWithHelpsVisitQualification
from InscriptCandidatesWithHelpsVisitQualifications import InscriptCandidatesWithHelpsVisitQualifications
from InscriptCandidatesWithHelpVisit import InscriptCandidatesWithHelpVisit
from InscriptCandidatesWithHelpVisitQualification import InscriptCandidatesWithHelpVisitQualification
from InscriptCandidatesWithHelpVisitQualifications import InscriptCandidatesWithHelpVisitQualifications
from InscriptCandidatesWithQualification import InscriptCandidatesWithQualification
from InscriptCandidatesWithQualifications import InscriptCandidatesWithQualifications
from InscriptCandidatesWithVisit import InscriptCandidatesWithVisit
from InscriptCandidatesWithVisitQualification import InscriptCandidatesWithVisitQualification
from InscriptCandidatesWithVisitQualifications import InscriptCandidatesWithVisitQualifications

VIOLET = '\033[38;2;128;0;128m'
GREEN = '\033[92m'
RESET = '\033[0m'

def RunRightWithTest():
    print(VIOLET + "===== Procédure de test d'inscription - avec paramètres optionnels =====" + RESET)
    
    test = InscriptCandidatesWithHelp()
    test.run()
    
    test = InscriptCandidatesWithHelpQualification()
    test.run()
    
    test = InscriptCandidatesWithHelpQualifications()
    test.run()
    
    test = InscriptCandidatesWithHelps()
    test.run()
    
    test = InscriptCandidatesWithHelpsQualification()
    test.run()
    
    test = InscriptCandidatesWithHelpsQualifications()
    test.run()
    
    test = InscriptCandidatesWithHelpsVisit()
    test.run()
    
    test = InscriptCandidatesWithHelpsVisitQualification()
    test.run()
    
    test = InscriptCandidatesWithHelpsVisitQualifications()
    test.run()
    
    test = InscriptCandidatesWithHelpVisit()
    test.run()
    
    test = InscriptCandidatesWithHelpVisitQualification()
    test.run()
    
    test = InscriptCandidatesWithHelpVisitQualifications()
    test.run()
    
    test = InscriptCandidatesWithQualification()
    test.run()
    
    test = InscriptCandidatesWithQualifications()
    test.run()
    
    test = InscriptCandidatesWithVisit()
    test.run()
    
    test = InscriptCandidatesWithVisitQualification()
    test.run()
    
    test = InscriptCandidatesWithVisitQualifications()
    test.run()
    
    print(GREEN + "Procédure Validée" + RESET)
    
if __name__ == "__main__":
    RunRightWithTest()