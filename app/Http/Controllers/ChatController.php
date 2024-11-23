<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $authUserId = Auth::id();

        // Retrieve all users except the currently logged-in user
        $users = User::where('user_id', '!=', $authUserId)
            ->get()
            ->map(function ($user) use ($authUserId) {
                $user->hasUnreadMessages = Message::where('sender_id', $user->user_id)
                    ->where('receiver_id', $authUserId)
                    ->where('is_read', false)
                    ->exists();

                $user->lastMessageContent = optional($user->lastMessage($authUserId))->content ?? 'No messages yet';

                return $user;
            });

        return view('student-organization.chat', compact('users'));
    }

    public function fetchMessages($receiverId)
    {
        $authUserId = Auth::user()->user_id;

        // Retrieve messages between the logged-in user and the selected user
        $messages = Message::where(function ($query) use ($receiverId, $authUserId) {
            $query->where('sender_id', $authUserId)->where('receiver_id', $receiverId);
        })
            ->orWhere(function ($query) use ($receiverId, $authUserId) {
                $query->where('sender_id', $receiverId)->where('receiver_id', $authUserId);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark messages as read
        Message::where('sender_id', $receiverId)
            ->where('receiver_id', $authUserId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json($messages);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,user_id',
            'content' => 'required|string|max:255',
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),            
            'receiver_id' => $request->receiver_id,
            'content' => $request->content,
        ]);

        return response()->json($message);
    }

    public function fetchUserInfo($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json([
            'username' => $user->username,
            'email' => $user->email,
            'created_at' => $user->created_at->format('d-m-Y'),
        ]);
    }
}
