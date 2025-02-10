TYPE = [
    "title",
    "subtitle",
    "valid",
    "text"
]

def write(str_msg: str, color: str, type: str = "text", size: int = 120, margin_size: int = 15, line_char: str = "=", color_reset: str = "\033[0m"):
    margin = 2 * (margin_size + 1)
    padding = (size - margin - len(str_msg)) // 2  
    
    
    if(size - margin < len(str_msg)):
        raise Exception("Message trop volumineux")
    
    if type not in TYPE:
        raise ValueError(f"Le type '{type}' n'est pas valide. Les types valides sont : {', '.join(TYPE)}")
    
    
    print(color)
    
    
    if(type in ["title", "subtitle"]):
        # Première ligne
        for i in range(size):
            print(line_char, end="")
        print("\n")
        
    
    # Seconde ligne
    for i in range(margin_size):
        print(line_char, end="")
        
    if(len(str_msg) % 2 == 0):
        for i in range(padding):
            print(line_char, end="")
            
        print(" " + str_msg + " ", end="")
        
        for i in range(padding):
            print(line_char, end="")
    else: 
        for i in range(padding):
            print(line_char, end="")
            
        print(" " + str_msg + " ", end="")
        
        for i in range(padding + 1):
            print(line_char, end="")
        
    for i in range(margin_size):
        print(line_char, end="")
    
    print("\n")
    
    
    if(type in ["title", "valid"]):
        # Troisième ligne
        for i in range(size):
            print(line_char, end="")
        print("\n")
    
    print(color_reset)