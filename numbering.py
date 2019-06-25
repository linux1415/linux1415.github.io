#11-25-17
#sample command: python number.py Desktop/music
#numbers all files in a folder
import os, os.path, sys
from subprocess import call

arg = sys.argv
if len(arg) < 2:
	print 'No input'
	sys.exit()
var  = sys.argv[1]
if os.path.isdir(var) == False:
	print 'Path does not exist'
	sys.exit()
count = 0
for x in sorted(os.listdir(var)):
	count += 1
	new = str(count) + '. ' + x
	os.rename((var + '/' + x), (var + '/' + new))
#if arg[2] == 'txt':
	#file1 = var + '/file.txt' 
	
