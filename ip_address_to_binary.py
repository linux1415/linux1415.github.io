import sys
list = [128, 64, 32, 16, 8, 4, 2, 1]
ip_binary = []
temp_list = []

def one_or_zero(x,num):
	if x / num > 0:
		x = x - num
		temp_list.append('1')
	else:
		temp_list.append('0')
	return x

def calc(a):
	global temp_list
	ip_address = a.split('.')
	for x in ip_address:
		x = int(x)
		for num in list:
			x = one_or_zero(x, num)
		binary_num = ''.join(temp_list)
		ip_binary.append(binary_num)
		temp_list = []

user_input = sys.argv
if len(user_input) > 1:
	calc(user_input[1])
	ip_address = '.'.join(ip_binary)
	print ip_address
