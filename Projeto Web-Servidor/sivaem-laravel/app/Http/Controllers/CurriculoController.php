<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Curriculo;

class CurriculoController extends Controller
{
    public function index(Request $request)
{
    // Recupera o cargo, se especificado, caso contrário, define como uma string vazia
    $cargo = $request->input('cargo', '');

    if ($cargo === '') {
        // Se nenhum cargo for especificado, retorna todos os currículos
        $curriculos = Curriculo::all();
    } else {
        // Se um cargo for especificado, retorna os currículos que correspondem ao cargo
        $curriculos = Curriculo::where('cargo', 'LIKE', "%$cargo%")->get();
    }

    return response()->json($curriculos);
}


    public function store(Request $request)
    {
        // Validar os dados da requisição
        $validatedData = $request->validate([
            'descricao' => 'required|string|max:255',
            'cargo' => 'required|string|max:255',
            'experiencia' => 'required|string|max:255',
            'salario' => 'required|numeric',
        ]);

        $user = $request->user();
        // Criar um novo currículo associado ao usuário logado
        $curriculo = new Curriculo();
        $curriculo->nome = $user->username;
        $curriculo->descricao = $validatedData['descricao'];
        $curriculo->cargo = $validatedData['cargo'];
        $curriculo->experiencia = $validatedData['experiencia'];
        $curriculo->salario = $validatedData['salario'];
        $curriculo->user_id = $request->user()->id; // Associar ao usuário logado

        if ($curriculo->save()) {
            return response()->json(['message' => 'Currículo adicionado com sucesso!']);
        } else {
            return response()->json(['message' => 'Erro ao adicionar currículo'], 500);
        }
    }

    public function update(Request $request, $id)
{
    // Validar os dados da requisição
    $validatedData = $request->validate([
        'descricao' => 'required|string|max:255',
        'cargo' => 'required|string|max:255',
        'experiencia' => 'required|string|max:255',
        'salario' => 'required|numeric',
    ]);

    // Obter o usuário logado
    $user = $request->user();

    // Encontrar o currículo pelo ID
    $curriculo = Curriculo::findOrFail($id);

    // Verificar se o usuário logado é o dono do currículo
    if ($curriculo->user_id !== $user->id) {
        return response()->json(['message' => 'Você não tem permissão para alterar este currículo'], 403);
    }

    // Atualizar os dados do currículo
    $curriculo->descricao = $validatedData['descricao'];
    $curriculo->cargo = $validatedData['cargo'];
    $curriculo->experiencia = $validatedData['experiencia'];
    $curriculo->salario = $validatedData['salario'];

    if ($curriculo->save()) {
        return response()->json(['message' => 'Currículo atualizado com sucesso!']);
    } else {
        return response()->json(['message' => 'Erro ao atualizar currículo'], 500);
    }
}


    public function destroy(Request $request, $id)
    {
        // Encontrar e excluir o currículo pelo ID e usuário logado
        $curriculo = Curriculo::where('id', $id)->where('user_id', $request->user()->id)->first();

        if (!$curriculo) {
            return response()->json(['message' => 'Currículo não encontrado'], 404);
        }

        if ($curriculo->delete()) {
            return response()->json(['message' => 'Currículo excluído com sucesso!']);
        } else {
            return response()->json(['message' => 'Erro ao excluir currículo'], 500);
        }
    }
}
