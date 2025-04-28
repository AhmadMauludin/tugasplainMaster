<?php

namespace App\Controllers;

use App\Models\ChatFriendModel;

class ChatFriend extends BaseController
{
    protected $chatModel;

    public function __construct()
    {
        $this->chatModel = new ChatFriendModel();
    }

    public function index($idfriendship)
    {
        $session = session();
        $userId = $session->get('id');

        // Mark semua chat sebagai dilihat
        $this->chatModel->markAsSeen($idfriendship, $userId);

        // Ambil data teman
        $friendshipModel = new \App\Models\FriendshipModel();
        $userModel = new \App\Models\UserModel();

        $friendship = $friendshipModel->find($idfriendship);

        if (!$friendship) {
            return redirect()->to('/chatfriend')->with('error', 'Data tidak ditemukan.');
        }

        $friendId = ($friendship['user_id'] == $userId) ? $friendship['friend_id'] : $friendship['user_id'];
        $friend = $userModel->find($friendId);

        $data = [
            'title' => 'Chat',
            'idfriendship' => $idfriendship,
            'chats' => $this->chatModel->getChats($idfriendship),
            'userId' => $userId,
            'friend' => $friend, // dikirim ke view
        ];

        return view('chatfriend/index', $data);
    }


    public function send()
    {
        $session = session();
        $userId = $session->get('id');
        $idfriendship = $this->request->getPost('idfriendship');
        $pesan = $this->request->getPost('pesan');
        $file = $this->request->getFile('attachment');
        $attachment = null;

        if ($file && !$file->getError()) {
            $attachment = $file->getRandomName();
            $file->move('uploads/chat', $attachment);
        }

        $this->chatModel->save([
            'idfriendship' => $idfriendship,
            'pengirim'     => $userId,
            'pesan'        => $pesan,
            'datetime'     => date('Y-m-d H:i:s'),
            'attachment'   => $attachment,
            'status'       => 'terkirim'
        ]);

        return redirect()->to('/chatfriend/index/' . $idfriendship);
    }
}
