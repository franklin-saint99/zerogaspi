<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Product extends Model
{
    protected $fillable = [
        'nom',
        'description',
        'prix',
        'prix_initial',
        'stock',
        'statut',
        'image',
        'category_id',
        'vendeur_id',
        'date_peremption',
    ];
 
    protected $casts = [
        'date_peremption' => 'date',
    ];
 
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
 
    public function vendeur()
    {
        return $this->belongsTo(User::class, 'vendeur_id');
    }
}
 