<?php

namespace App\Models;

class Like extends Model {
    protected string $table = 'likes';

    protected array $fillable = [
        'user_id', 
        'likeable_type', 
        'likeable_id'
    ];

    protected array $hidden = [
        'created_at'
    ];
    
    /**
     * Метод для получения автора лайка.
     *
     * @return User Автор лайка.
     */
    public function author(): User
    {
        return new User($this -> getAttribute('user_id'));
    }
    
    /**
     * Метод для получения связанной модели.
     *
     * @return Model Связанная модель.
     */
    public function getRelated(): Model|\Exception
    {
        $type = $this -> getAttribute('likeable_type');
        $id = $this -> getAttribute('likeable_id');

        return match ($type) {
            'post' => new Post($id),
            'comment' => new Comment($id),
            default => throw new \Exception("Unknown likeable type: {$type}"),
        };
    }
}