import os
import sys
import time

from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys

current_dir = os.path.dirname(os.path.abspath(__file__))

parent_dir = os.path.dirname(current_dir)

sys.path.append(parent_dir)

from Applications.Inscript.TestApplications import TestApplications

class TestCandidates(TestApplications):
    """
    Classe destinée aux tests des fonctionnalités de manipulations de candidats      
    """
    
    APP_CANDIDATES_BL_A = "a"
    APP_CANDIDATES_BL_B = "b"
    APP_CANDIDATES_BL_C = "c"
    
    def start(self):
        """
        Méthode préparant l'application pour le test

        Etapes:
            1. Connexion à l'application
            2. Navigation vers le menu candidatures

        Returns:
            Driver
        """
        driver = self.connect()

        self.goToApplicationsPage(driver)
        
        time.sleep(self.SLEEP_TIME)
        
        self.clickOnFirstElmt(driver)
        
        time.sleep(self.SLEEP_TIME)  
        
        self.linkTest(driver, r"http://localhost/ypopsi/index.php\?candidates=\d+")
        
        return driver
    
    # * GET * #
    def getBL(self, driver: webdriver, checkboxs: list, state: bool = True):
        res = True
        
        i = 0
        size = len(checkboxs)
        while(res and i < size):
            obj = checkboxs[i]
            item = self.find_element_by_id(driver, obj)
            
            print(f"Checkbox {obj} - Selected: {item.is_selected()}")
            
            if((state and not item.is_selected()) or (not state and item.is_selected())):
                res = False
                
            i += 1
            
        return res
        
    # * SET * #
    def setRating(self, driver, rate: int):
        star = self.find_element_by_id(driver, "notation" + str(rate))
        
        star.click()
        
    def setdesc(self, driver, desc: str):
        desc_input = self.find_element_by_id(driver, "description")
        
        desc_input.setKeys(desc)
        
    def setBL(self, driver, checkbox: str, state: bool = True):
        input = self.find_element_by_id(driver, checkbox)
        
        if((state and not input.is_selected()) or (not state and input.is_selected())):
            input.click()
        
    def setratingForm(self, driver, rate: int, desc: str, a: bool, b: bool, c: bool):
        self.setRating(driver, rate)
        
        if(a):
            self.setBL(driver, "a")
            
        if(b):
            self.setBL(driver, "b")
            
        if(c):
            self.setBL(driver, "c")
            
        self.setdesc(self, driver, desc)