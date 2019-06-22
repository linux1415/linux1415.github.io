import sys
list = [128, 64, 32, 16, 8, 4, 2, 1]
base10_ip = []
def convert(ip):
	global ip_address
	ip = ip.replace(' ', '.')
	ip = ip.split('.')
	for item in ip:
		ip_list = []
		for x in item:
			ip_list.append(x)
		count = -1
		ip_address = 0
		for num in list:
			list_index = list.index(num)
			count += 1
			if ip_list[count] == '1':
				ip_address += num
		base10_ip.append(str(ip_address))
			
		
user_input = sys.argv
if len(user_input) > 1:
	if len(user_input) > 2:
		binary_ip = '.'.join(user_input[1:])
		convert(binary_ip)
	else:
		convert(user_input[1])
	base10_ip_string = '.'.join(base10_ip)
	print base10_ip_string
		
	
