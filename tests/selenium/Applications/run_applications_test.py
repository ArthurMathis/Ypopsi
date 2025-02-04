import os
import sys

sys.path.append(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
from InscriptCandidates import InscriptCandidates

from InscriptCandidatesWrongName1 import InscriptCandidatesWrongName1
from InscriptCandidatesWrongName2 import InscriptCandidatesWrongName2
from InscriptCandidatesWrongName3 import InscriptCandidatesWrongName3

from InscriptCandidatesWrongFirstname1 import InscriptCandidatesWrongFirstname1
from InscriptCandidatesWrongFirstname2 import InscriptCandidatesWrongFirstname2

from InscriptCandidatesWrongFirstname3 import InscriptCandidatesWrongFirstname3
from InscriptCandidatesWrongEmail1 import InscriptCandidatesWrongEmail1
from InscriptCandidatesWrongEmail2 import InscriptCandidatesWrongEmail2
from InscriptCandidatesWrongEmail3 import InscriptCandidatesWrongEmail3

from InscriptCandidatesWrongPhone1 import InscriptCandidatesWrongPhone1
from InscriptCandidatesWrongPhone2 import InscriptCandidatesWrongPhone2

from InscriptCandidatesWrongCity1 import InscriptCandidatesWrongCity1
from InscriptCandidatesWrongCity2 import InscriptCandidatesWrongCity2
from InscriptCandidatesWrongCity3 import InscriptCandidatesWrongCity3
from InscriptCandidatesWrongCity4 import InscriptCandidatesWrongCity4

from InscriptCandidatesWrongPostcode1 import InscriptCandidatesWrongPostcode1
from InscriptCandidatesWrongPostcode2 import InscriptCandidatesWrongPostcode2
from InscriptCandidatesWrongPostcode3 import InscriptCandidatesWrongPostcode3

def main():
    test = InscriptCandidates()
    test.run()
    
    # * NAME * #
    test = InscriptCandidatesWrongName1()
    test.run()

    test = InscriptCandidatesWrongName2()
    test.run()
    
    test = InscriptCandidatesWrongName3()
    test.run()
    
    # * FIRSTNAME * #
    test = InscriptCandidatesWrongFirstname1()
    test.run()

    test = InscriptCandidatesWrongFirstname2()
    test.run()
    
    test = InscriptCandidatesWrongFirstname3()
    test.run()
    
    # * EMAIL * #
    test = InscriptCandidatesWrongEmail1()
    test.run()
    
    test = InscriptCandidatesWrongEmail2()
    test.run()
    
    test = InscriptCandidatesWrongEmail3()
    test.run()
    
    # * PHONE * #
    test = InscriptCandidatesWrongPhone1()
    test.run()
    
    test = InscriptCandidatesWrongPhone2()
    test.run()
    
    # * CITY * #
    test = InscriptCandidatesWrongCity1()
    test.run()
    
    test = InscriptCandidatesWrongCity2()
    test.run()
    
    test = InscriptCandidatesWrongCity3()
    test.run()
    
    test = InscriptCandidatesWrongCity4()
    test.run()
    
    # * POSTCODE * #
    test = InscriptCandidatesWrongPostcode1()
    test.run()
    
    test = InscriptCandidatesWrongPostcode2()
    test.run()
    
    test = InscriptCandidatesWrongPostcode3()
    test.run()

if __name__ == "__main__":
    main()