<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Vacancy",
 *     type="object",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         example="PHP Developer"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         example="We are looking for a PHP developer with Laravel experience."
 *     ),
 *     @OA\Property(
 *         property="min_salary",
 *         type="number",
 *         example=1000
 *     ),
 *     @OA\Property(
 *         property="max_salary",
 *         type="number",
 *         example=2000
 *     ),
 *     @OA\Property(
 *         property="department_id",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="is_hot",
 *         type="boolean",
 *         example=true
 *     )
 * )
 */

class Vacancy extends Model
{
    use HasFactory;

    protected $fillable = [
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
    ];

    protected $casts = [
        'requirements' => 'array',
        'benefits' => 'array',
        'is_hot' => 'boolean',
        'published_from' => 'date',
        'published_to' => 'date',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function setRequirementsAttribute($value)
    {
        $this->attributes['requirements'] = json_encode($value);
    }

    public function setBenefitsAttribute($value)
    {
        $this->attributes['benefits'] = json_encode($value);
    }
}
