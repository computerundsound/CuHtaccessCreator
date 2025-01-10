# This tool creates .htpwd files (wich are important for .htaccess-directory secure)

You create a pw.txt file, for example with this content

> uncle_ben:hisPassword:some remarks  
> ant_tina:herPassword:some more remarks

**You see, you have 3 fields separated with colon ':'**

>Username:Password:Remark

Every line is one User with Password. The remark is an option, 
you don't need (it is only) for your information. 

At first, create a pw.txt - file.
Then edit the user-config.ini file (inserts paths to the pw.txt and the .htpwd - files)

Then run on console this command (if you are in the root of this project)

    php console/bin cu:pw-protect

(on some machines you don't need the "php" in front of the command)

The .htpwd - files will be created.

It is a security problem, if you leave the pw.txt on your server - (because in these files
you can see the passwords in clear text)

**Use at your own risk!**

Jörg Wrase
Bremen, Germany
