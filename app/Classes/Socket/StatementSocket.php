<?php

namespace App\Classes\Socket;

use App\Classes\Socket\Base\BaseSocket;
use Ratchet\ConnectionInterface;

class StatementSocket extends BaseSocket
{
    protected $clients;
    protected $rooms;
    protected $users;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $data = json_decode($msg);

        if ($data->message === 'join room') {
            $this->users[$from->resourceId] = $data->user;
            $this->rooms[$data->user->organization_id][$from->resourceId] = $from;

            echo 'User: ' . $this->users[$from->resourceId]->firstname . ' connected to ' . $this->users[$from->resourceId]->organization_id . ' organization' . "\n";
        }

        elseif ($data->message === 'leave room') {
            $orgId = $this->users[$from->resourceId]->organization_id;
            unset($this->rooms[$orgId][$from->resourceId]);
            unset($this->users[$from->resourceId]);
        }

        elseif ($data->message === 'new statement') {

        }

        elseif ($data->message === 'accept statement') {
            $orgId = $this->users[$from->resourceId]->organization_id;
            $user = $this->users[$from->resourceId];
            $employees = $this->rooms[$orgId];
            $localData = array (
                'message' => $data->message,
                'name' => $user->firstname . ' ' . $user->lastname,
                'repairManId' => $user->id,
                'statementId' => $data->statementId,
            );

            foreach ($employees as $employee) {
                if ($employee->resourceId == $from->resourceId) continue;
                $employee->send(json_encode($localData));
            }
        }

        elseif ($data->message === 'complete statement') {
            $orgId = $this->users[$from->resourceId]->organization_id;
            $employees = $this->rooms[$orgId];
            $localData = array(
                'message' => $data->message,
                'statementId' => $data->statementId
            );

            foreach ($employees as $employee) {
                if ($employee->resourceId == $from->resourceId) continue;
                $employee->send(json_encode($localData));
            }
        }
//        $orgId = $this->users[$from->resourceId]->organization_id;
//        echo $this->rooms[$orgId];

//        $from->send(json_encode($this->users));

//        foreach ($this->clients as $client) {
//            $client->send($msg);
//        }
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);

        echo 'User: ' . $this->users[$conn->resourceId]->firstname . ' disconnected from ' . $this->users[$conn->resourceId]->organization_id . ' organization' . "\n";

        if (empty($this->users[$conn->resourceId])) return;

        $orgId = $this->users[$conn->resourceId]->organization_id;
        unset($this->rooms[$orgId][$conn->resourceId]);
        unset($this->users[$conn->resourceId]);

    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occured: {$e->getMessage()} \n";

        $conn->close();
    }
}
