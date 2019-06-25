#12-17-17
#Enter the movie; start time; end time
#Example: python portion.py Desktop/video 00:23:21 01:12:43
import os, sys, os.path
from subprocess import call

list = sys.argv

if len(list) < 4:
	print '\nIncorrect Input'
	print 'Enter the movie; start time; end time'
	print 'Example: python portion.py Desktop/video 00:23:21 01:12:43\n'
	sys.exit()

def portion_cutter(s, m, d, new_movie):
	call(['ffmpeg', '-ss', str(s), '-i', str(m), '-c', 'copy', '-t', str(d), new_movie])

movie = list[1]

start_seconds = list[2]
start_seconds = start_seconds.split(":")
start_seconds = (int(start_seconds[0]) * 3600) + (int(start_seconds[1]) * 60) + float(start_seconds[2])

duration = list[3]
duration = duration.split(":")
duration = (int(duration[0]) * 3600) + (int(duration[1]) * 60) + float(duration[2])
duration = str(duration - start_seconds)

split_list = os.path.split(list[1])
new_file = 'new_' + split_list[1]
new_movie = os.path.join(split_list[0], new_file)

portion_cutter(str(start_seconds), movie, duration, new_movie)
