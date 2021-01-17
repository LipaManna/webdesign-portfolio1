dict = {'Biriyani': 150,
        'Noodles': 120,
        'Coffee': 50,
        'Tea': 30,
        'Nun': 20,
        'Combo': 300,
        'Manchurian': 200}
for key in dict:
    print(key, dict[key])

total = 0
for (k, v) in dict.items():
    menu = input('Enter your order')
    if menu == 'done':
        break
    v1 = dict.get(menu)

    total = total + v1
print(total)

if total > 500:
    print('Warning,you are running above 500')