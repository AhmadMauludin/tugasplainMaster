<?php

namespace App\Models;

use CodeIgniter\Model;

class FriendshipModel extends Model
{
    protected $table = 'friendships';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'friend_id', 'status'];

    // Menambahkan permintaan pertemanan
    public function addFriendRequest($userId, $friendId)
    {
        $data = [
            'user_id' => $userId,
            'friend_id' => $friendId,
            'status' => 'pending',
        ];

        return $this->insert($data);
    }

    // Mendapatkan daftar teman (yang sudah accepted), dengan informasi nama dari tabel user
    public function getFriends($userId)
    {
        return $this->select('user.nama, user.foto, friendships.*')
            ->join('user', 'user.id = IF(friendships.user_id = ' . $userId . ', friendships.friend_id, friendships.user_id)')
            ->where('friendships.status', 'accepted')
            ->groupStart()
            ->where('friendships.user_id', $userId)
            ->orWhere('friendships.friend_id', $userId)
            ->groupEnd()
            ->findAll();
    }

    // Mendapatkan daftar permintaan masuk yang pending (dikirim ke user login)
    public function getFriendRequests($userId)
    {
        return $this->select('user.nama, user.foto, friendships.*')
            ->join('user', 'user.id = friendships.user_id')
            ->where('friendships.friend_id', $userId)
            ->where('friendships.status', 'pending')
            ->findAll();
    }

    public function getSentRequests($userId)
    {
        return $this->select('user.nama, user.foto, friendships.*')
            ->join('user', 'user.id = friendships.friend_id')
            ->where('friendships.user_id', $userId)
            ->where('friendships.status', 'pending')
            ->findAll();
    }


    // Menerima permintaan pertemanan
    public function acceptFriendRequest($requestId)
    {
        return $this->update($requestId, ['status' => 'accepted']);
    }

    // Menolak permintaan pertemanan
    public function declineFriendRequest($requestId)
    {
        return $this->delete($requestId);
    }

    // Menghapus pertemanan berdasarkan ID pertemanan
    public function removeFriendById($friendshipId)
    {
        return $this->delete($friendshipId);
    }
}
