<?php

namespace App\Controllers;

use App\Models\ChatGroupModel;
use App\Models\GroupsModel;
use App\Models\MemberModel;
use App\Models\UserModel;

class ChatGroup extends BaseController
{
    protected $chatGroupModel;

    public function __construct()
    {
        $this->chatGroupModel = new ChatGroupModel();
    }

    public function index($idgroup)
    {
        $session = session();
        $userId = $session->get('id');

        $groupModel = new GroupsModel();
        $memberModel = new MemberModel();
        $userModel = new UserModel();

        $group = $groupModel->find($idgroup);
        $members = $memberModel->where('idgroups', $idgroup)->findAll();

        $memberDetails = [];
        foreach ($members as $member) {
            $memberDetails[] = $userModel->find($member['iduser']);
        }

        // Ambil semua chat
        $db = \Config\Database::connect();
        $builder = $db->table('chatgroups');
        $builder->select('chatgroups.*, user.nama, user.foto');
        $builder->join('user', 'user.id = chatgroups.pengirim');
        $builder->where('chatgroups.idgroups', $idgroup);
        $builder->orderBy('chatgroups.datetime', 'ASC');
        $chats = $builder->get()->getResultArray();

        $data = [
            'title' => 'Chat Group',
            'idgroup' => $idgroup,
            'group' => $group,
            'members' => $memberDetails,
            'chats' => $chats,
            'userId' => $userId,
        ];

        return view('chatgroup/index', $data);
    }


    public function send()
    {
        $session = session();
        $userId = $session->get('id');

        $idgroups = $this->request->getPost('idgroups');
        $pesan = $this->request->getPost('pesan');
        $attachment = null;

        if ($file = $this->request->getFile('attachment')) {
            if ($file->isValid() && !$file->hasMoved()) {
                $attachmentName = $file->getRandomName();
                $file->move('uploads/chatgroups', $attachmentName);
                $attachment = $attachmentName;
            }
        }

        $this->chatGroupModel->insert([
            'idgroups' => $idgroups,
            'pengirim' => $userId,
            'pesan' => $pesan,
            'attachment' => $attachment,
        ]);

        return redirect()->to('/chatgroup/index/' . $idgroups);
    }
}
