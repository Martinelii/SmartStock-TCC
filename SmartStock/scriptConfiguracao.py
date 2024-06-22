import tkinter as tk
from tkinter import filedialog

def select_file(entry):
    file_path = filedialog.askopenfilename(filetypes=[("Text files", "*.txt")])
    entry.delete(0, tk.END)
    entry.insert(0, file_path)

def configurar():
    departamento_file = entry_departamento.get()
    cargo_file = entry_cargo.get()
    print(f"Arquivo de Departamento: {departamento_file}")
    print(f"Arquivo de Cargo: {cargo_file}")
    # Aqui você pode adicionar o processamento necessário dos arquivos selecionados

# Criação da janela principal
root = tk.Tk()
root.title("Configuração Rápida")
root.geometry("400x300")

# Configuração dos widgets
label_title = tk.Label(root, text="CONFIGURAÇÃO RÁPIDA", font=("Helvetica", 16))
label_title.pack(pady=20)

label_departamento = tk.Label(root, text="Arquivo de Departamento:")
label_departamento.pack()

entry_departamento = tk.Entry(root, width=50)
entry_departamento.pack(pady=5)
button_departamento = tk.Button(root, text="Selecionar", command=lambda: select_file(entry_departamento))
button_departamento.pack()

label_cargo = tk.Label(root, text="Arquivo de Cargo:")
label_cargo.pack()

entry_cargo = tk.Entry(root, width=50)
entry_cargo.pack(pady=5)
button_cargo = tk.Button(root, text="Selecionar", command=lambda: select_file(entry_cargo))
button_cargo.pack()

button_configurar = tk.Button(root, text="Configurar", bg="green", fg="white", command=configurar)
button_configurar.pack(pady=20)

# Execução da interface gráfica
root.mainloop()
