<?php

namespace App\Http\Controllers;

use App\Models\Vaga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VagaController extends Controller
{
    public function index(Request $request)
    {
        $cargo = $request->input('cargo', '');
        $tipo_user = session('tipo_user', ''); // Supondo que 'tipo_user' seja armazenado na sessão

        if ($cargo === '' && $tipo_user == 2) {
            $vagas = Vaga::where('nome', '=', session('username'))->get();
        } else {
            $vagas = Vaga::where('cargo', 'LIKE', "%$cargo%")->get();
        }

        return response()->json($vagas);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'descricao' => 'required|string|max:255|min:5',
            'cargo' => 'required|string|max:20|min:2',
            'salario' => 'required|numeric',
        ]);

      

        $user = $request->user();
        // Criar uma nova vaga associada ao usuário logado
        $vaga = new Vaga();
        $vaga->nome = $user->username;
        $vaga->descricao = $validatedData['descricao'];
        $vaga->cargo = $validatedData['cargo'];
        $vaga->salario = $validatedData['salario'];
        $vaga->id_user = $request->user()->id; // Associar ao usuário logado


        if ($vaga->save()) {
            return response()->json(['message' => 'Vaga adicionada com sucesso!']);
        } else {
            return response()->json(['error' => 'Erro ao adicionar vaga'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        // Validação dos dados
        $validatedData = $request->validate([
            'descricao' => 'required|string|max:255|min:5',
            'cargo' => 'required|string|max:20|min:2',
            'salario' => 'required|numeric',
        ]);
    
        // Obter o usuário logado
        $user = $request->user();
    
        // Buscar a vaga pelo ID
        $vaga = Vaga::findOrFail($id);
    
        // Verificar se o usuário logado é o mesmo que criou a vaga
        if ($vaga->id_user !== $user->id) {
            return response()->json(['error' => 'Você não tem permissão para alterar esta vaga'], 403);
        }
    
        // Atualizar os campos da vaga
        $vaga->descricao = $validatedData['descricao'];
        $vaga->cargo = $validatedData['cargo'];
        $vaga->salario = $validatedData['salario'];
    
        // Salvar a vaga
        if ($vaga->save()) {
            return response()->json(['message' => 'Vaga alterada!', 'vaga' => $vaga]);
        } else {
            return response()->json(['error' => 'Erro ao alterar vaga'], 500);
        }
    }
    

    public function destroy($id)
    {
        $vaga = Vaga::findOrFail($id);
        $vaga->delete();

        return response()->json(['message' => 'Vaga excluída com sucesso!']);
    }
}
