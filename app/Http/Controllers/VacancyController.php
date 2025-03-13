<?php

namespace App\Http\Controllers;

use App\Models\Vacancy;
use Illuminate\Http\Request;


/**
 * @OA\Info(
 *     title="Job Portal API",
 *     version="1.0.0",
 *     description="API для управління вакансіями"
 * )
 */

/**
 * @OA\Tag(
 *     name="Vacancies",
 *     description="Операції з вакансіями"
 * )
 */

/**
 * @OA\Schema(
 *     schema="VacancyRequest",
 *     type="object",
 *     required={"title", "description"},
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="Title of the vacancy"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Description of the vacancy"
 *     )
 * )
 */


class VacancyController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/vacancies",
     *     summary="Отримати список вакансій",
     *     tags={"Vacancies"},
     *     @OA\Parameter(
     *         name="title",
     *         in="query",
     *         description="Пошук за назвою вакансії",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="department_id",
     *         in="query",
     *         description="Фільтрація за ID департаменту",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="min_salary",
     *         in="query",
     *         description="Мінімальна зарплата",
     *         required=false,
     *         @OA\Schema(type="number")
     *     ),
     *     @OA\Parameter(
     *         name="max_salary",
     *         in="query",
     *         description="Максимальна зарплата",
     *         required=false,
     *         @OA\Schema(type="number")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Список вакансій",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Vacancy")
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = Vacancy::query();

        if ($request->has('title')) {
            $query->where('title', 'like', '%' . $request->input('title') . '%');
        }

        if ($request->has('department_id')) {
            $query->where('department_id', $request->input('department_id'));
        }

        if ($request->has('min_salary')) {
            $query->where('min_salary', '>=', $request->input('min_salary'));
        }
        if ($request->has('max_salary')) {
            $query->where('max_salary', '<=', $request->input('max_salary'));
        }

        if ($request->has('is_hot')) {
            $query->where('is_hot', $request->input('is_hot'));
        }

        $vacancies = $query->paginate(10);

        return response()->json($vacancies);
    }

    /**
     * @OA\Post(
     *     path="/api/vacancies",
     *     summary="Створити нову вакансію",
     *     tags={"Vacancies"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/VacancyRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Вакансія успішно створена",
     *         @OA\JsonContent(ref="#/components/schemas/Vacancy")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'array',
            'benefits' => 'array',
            'min_salary' => 'nullable|numeric|min:0',
            'max_salary' => 'nullable|numeric|min:0',
            'contact_name' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:20',
            'department_id' => 'required|exists:departments,id',
            'is_hot' => 'boolean',
            'published_from' => 'nullable|date',
            'published_to' => 'nullable|date|after_or_equal:published_from',
        ]);

        $vacancy = Vacancy::create($request->only([
            'title',
            'description',
            'requirements',
            'benefits',
            'min_salary',
            'max_salary',
            'contact_name',
            'contact_phone',
            'department_id',
            'is_hot',
            'published_from',
            'published_to'
        ]));

        return response()->json($vacancy, 201);
    }

    public function show(Vacancy $vacancy)
    {
        return response()->json($vacancy->load('department'));
    }

    public function update(Request $request, Vacancy $vacancy)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'array',
            'benefits' => 'array',
            'min_salary' => 'nullable|numeric|min:0',
            'max_salary' => 'nullable|numeric|min:0',
            'contact_name' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:20',
            'department_id' => 'required|exists:departments,id',
            'is_hot' => 'boolean',
            'published_from' => 'nullable|date',
            'published_to' => 'nullable|date|after_or_equal:published_from',
        ]);

        $vacancy->update($request->only([
            'title',
            'description',
            'requirements',
            'benefits',
            'min_salary',
            'max_salary',
            'contact_name',
            'contact_phone',
            'department_id',
            'is_hot',
            'published_from',
            'published_to'
        ]));

        return response()->json($vacancy);
    }

    public function destroy(Vacancy $vacancy)
    {
        $vacancy->delete();

        return response()->json(['message' => 'Vacancy deleted successfully']);
    }
}
