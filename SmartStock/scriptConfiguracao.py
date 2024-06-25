import tkinter as tk
from tkinter import filedialog, messagebox
import mysql.connector

def select_file(entry):
    file_path = filedialog.askopenfilename(filetypes=[("Text files", "*.txt")])
    entry.delete(0, tk.END)
    entry.insert(0, file_path)

def validar_departamento(lines):
    for line in lines:
        data = line.strip().split(';')
        if len(data) != 2:
            return False
    return True

def validar_cargo(lines):
    for line in lines:
        data = line.strip().split(';')
        if len(data) != 3:
            return False
    return True

def configurar():
    departamento_file = entry_departamento.get()
    cargo_file = entry_cargo.get()
    
    if departamento_file:
        insert_departamento(departamento_file)
    
    if cargo_file:
        insert_cargo(cargo_file)
    
    messagebox.showinfo("Sucesso", "Arquivos configurados com sucesso!")

def insert_departamento(file_path):
    try:
        with open(file_path, 'r', encoding='utf-8') as file:
            lines = file.readlines()
        
        if not validar_departamento(lines):
            raise ValueError("O arquivo de departamento está no formato incorreto.")
        
        conn = mysql.connector.connect(
            host="127.0.0.1",
            user="root",
            password="",
            database="db_tcc"
        )
        cursor = conn.cursor()
        
        for line in lines:
            data = line.strip().split(';')
            if len(data) == 2:
                cod_setor, setor = data
                cursor.execute("INSERT INTO departamento (CodSetor, Setor) VALUES (%s, %s)", (cod_setor, setor))
        
        conn.commit()
        cursor.close()
        conn.close()
    except Exception as e:
        messagebox.showerror("Erro", f"Erro ao inserir dados no banco de dados: {e}")

def insert_cargo(file_path):
    try:
        with open(file_path, 'r', encoding='utf-8') as file:
            lines = file.readlines()
        
        if not validar_cargo(lines):
            raise ValueError("O arquivo de cargo está no formato incorreto.")
        
        conn = mysql.connector.connect(
            host="127.0.0.1",
            user="root",
            password="",
            database="db_tcc"
        )
        cursor = conn.cursor()
        
        for line in lines:
            data = line.strip().split(';')
            if len(data) == 3:
                cod_cargo, cargo, funcao = data
                cursor.execute("INSERT INTO cargo (CodCargo, Cargo, Funcao) VALUES (%s, %s, %s)", (cod_cargo, cargo, funcao))
        
        conn.commit()
        cursor.close()
        conn.close()
    except Exception as e:
        messagebox.showerror("Erro", f"Erro ao inserir dados no banco de dados: {e}")

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
