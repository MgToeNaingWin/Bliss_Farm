<?php

namespace Database\Seeders;

use App\Models\Chat;
use App\Models\ChatParticipant;
use App\Models\Message;
use App\Models\MessageReaction;
use App\Models\MessageStatus;
use App\Models\User;
use Illuminate\Database\Seeder;

class ChatSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'user')->get();

        if ($users->count() < 3) {
            $this->command->warn('Need at least 3 users. Run UserSeeder first.');
            return;
        }

        $user1 = $users[0];
        $user2 = $users[1];
        $user3 = $users[2];
        $user4 = $users->slice(3, 1)->first() ?? $users[0];

        // ── Individual Chats ──

        // Chat between user1 and user2
        $chat1 = Chat::create(['type' => 'individual', 'created_by' => $user1->id]);
        ChatParticipant::insert([
            ['chat_id' => $chat1->id, 'user_id' => $user1->id, 'role' => 'admin', 'joined_at' => now()],
            ['chat_id' => $chat1->id, 'user_id' => $user2->id, 'role' => 'member', 'joined_at' => now()],
        ]);

        $messages1 = [
            ['sender_id' => $user1->id, 'content' => 'မင်္ဂလာပါ ကိုကို', 'minutes_ago' => 120],
            ['sender_id' => $user2->id, 'content' => 'မင်္ဂလာပါ ညီလေး', 'minutes_ago' => 118],
            ['sender_id' => $user1->id, 'content' => 'အခုလောလောဆယ် နွားခြံမှာ နွား ၂၀ ရှိတယ်', 'minutes_ago' => 115],
            ['sender_id' => $user2->id, 'content' => 'ကောင်းပါတယ်။ နွားအကြောင်း ဘာမေးချင်လဲ?', 'minutes_ago' => 110],
            ['sender_id' => $user1->id, 'content' => 'နွားတွေ အစာကျွေးတာနဲ့ပတ်သက်ပြီး မေးချင်တာရှိလို့', 'minutes_ago' => 105],
            ['sender_id' => $user2->id, 'content' => 'မေးပါ၊ ကူညီပါ့မယ်', 'minutes_ago' => 100],
            ['sender_id' => $user1->id, 'content' => 'နွားတွေကို တစ်နေ့ ဘယ်နှစ်ကြိမ် အစာကျွေးသင့်လဲ?', 'minutes_ago' => 95],
            ['sender_id' => $user2->id, 'content' => 'တစ်နေ့ ၂ ကြိမ် ကျွေးသင့်တယ်။ မနက်နှင့် ညနေ ခွဲပြီး', 'minutes_ago' => 90],
        ];

        foreach ($messages1 as $i => $msg) {
            Message::create([
                'chat_id' => $chat1->id,
                'sender_id' => $msg['sender_id'],
                'type' => 'text',
                'content' => $msg['content'],
                'created_at' => now()->subMinutes($msg['minutes_ago']),
            ]);
        }

        // Chat between user1 and user3
        $chat2 = Chat::create(['type' => 'individual', 'created_by' => $user3->id]);
        ChatParticipant::insert([
            ['chat_id' => $chat2->id, 'user_id' => $user1->id, 'role' => 'member', 'joined_at' => now()],
            ['chat_id' => $chat2->id, 'user_id' => $user3->id, 'role' => 'admin', 'joined_at' => now()],
        ]);

        $messages2 = [
            ['sender_id' => $user3->id, 'content' => 'ဟေလို ဦးကျော်', 'minutes_ago' => 60],
            ['sender_id' => $user1->id, 'content' => 'ဟေလို ဒေါ်မြတ်', 'minutes_ago' => 58],
            ['sender_id' => $user3->id, 'content' => 'ကျန်းမာရေး ဘယ်လိုလဲ?', 'minutes_ago' => 55],
            ['sender_id' => $user1->id, 'content' => 'ကောင်းပါတယ်။ ဒေါ်မြတ်ကရော?', 'minutes_ago' => 50],
            ['sender_id' => $user3->id, 'content' => 'ကောင်းပါတယ်။ နွားရောဂါ အကြောင်း ပြောချင်လို့', 'minutes_ago' => 45],
            ['sender_id' => $user1->id, 'content' => 'ဟုတ်ကဲ့၊ ဘာမေးချင်လဲ?', 'minutes_ago' => 40],
        ];

        foreach ($messages2 as $i => $msg) {
            Message::create([
                'chat_id' => $chat2->id,
                'sender_id' => $msg['sender_id'],
                'type' => 'text',
                'content' => $msg['content'],
                'created_at' => now()->subMinutes($msg['minutes_ago']),
            ]);
        }

        // ── Group Chat ──

        $groupChat = Chat::create([
            'type' => 'group',
            'name' => 'Bliss Farm မွေးမြူရေး အကြံပြုချက်',
            'created_by' => $user1->id,
        ]);

        ChatParticipant::insert([
            ['chat_id' => $groupChat->id, 'user_id' => $user1->id, 'role' => 'admin', 'joined_at' => now()],
            ['chat_id' => $groupChat->id, 'user_id' => $user2->id, 'role' => 'member', 'joined_at' => now()],
            ['chat_id' => $groupChat->id, 'user_id' => $user3->id, 'role' => 'member', 'joined_at' => now()],
            ['chat_id' => $groupChat->id, 'user_id' => $user4->id, 'role' => 'member', 'joined_at' => now()],
        ]);

        $groupMessages = [
            ['sender_id' => $user1->id, 'content' => 'အုပ်စုဖွဲ့ပြီးပြီ။ နွားမွေးမြူရေးအကြောင်း ဆွေးနွေးကြရအောင်', 'minutes_ago' => 200],
            ['sender_id' => $user2->id, 'content' => 'ကောင်းပါတယ်။ ကျွန်တော့် နွား ၃၀ ရှိတယ်', 'minutes_ago' => 195],
            ['sender_id' => $user3->id, 'content' => 'ကျွန်မ နွား ၁၅ ရှိတယ်။ မွေးဖူးတာ ၂ နှစ်ရှိပြီ', 'minutes_ago' => 190],
            ['sender_id' => $user4->id, 'content' => 'ကျွန်တော် အသစ်စတင်မွေးမြူနေတာ။ အကြံဉာဏ်ပေးပါ', 'minutes_ago' => 185],
            ['sender_id' => $user1->id, 'content' => 'ပထမဆုံး နွားမွေးခြံ ဆောက်ပုံကနေ စကြည့်ရအောင်', 'minutes_ago' => 180],
            ['sender_id' => $user2->id, 'content' => 'မှန်ပါတယ်။ ခြံကောင်းကောင်းဆောက်ရင် နွားတွေ ကျန်းမာမယ်', 'minutes_ago' => 175],
            ['sender_id' => $user3->id, 'content' => 'အစာကျွေးတာကလည်း အရေးကြီးတယ်နော်', 'minutes_ago' => 170],
            ['sender_id' => $user1->id, 'content' => 'ဟုတ်ပါတယ်။ အစာကျွေးနည်းကို ဆွေးနွေးကြရအောင်', 'minutes_ago' => 165],
            ['sender_id' => $user4->id, 'content' => 'အစာကျွေးတာ ဘယ်လို ကျွေးသင့်လဲ?', 'minutes_ago' => 160],
            ['sender_id' => $user2->id, 'content' => 'မနက် ၆ နာရီနှင့် ညနေ ၅ နာရီ ကျွေးတယ်', 'minutes_ago' => 155],
            ['sender_id' => $user1->id, 'content' => 'ရေကလည်း အမြဲရအောင်ထားပေးရမယ်', 'minutes_ago' => 150],
            ['sender_id' => $user3->id, 'content' => 'ကျန်းမာရေး စောင့်ကြည့်တာကလည်း အရေးကြီးတယ်', 'minutes_ago' => 145],
        ];

        foreach ($groupMessages as $msg) {
            Message::create([
                'chat_id' => $groupChat->id,
                'sender_id' => $msg['sender_id'],
                'type' => 'text',
                'content' => $msg['content'],
                'created_at' => now()->subMinutes($msg['minutes_ago']),
            ]);
        }

        // ── Add some reactions ──
        $lastGroupMsg = Message::where('chat_id', $groupChat->id)->latest()->first();
        if ($lastGroupMsg) {
            MessageReaction::create(['message_id' => $lastGroupMsg->id, 'user_id' => $user2->id, 'emoji' => '👍']);
            MessageReaction::create(['message_id' => $lastGroupMsg->id, 'user_id' => $user3->id, 'emoji' => '❤️']);
        }

        // ── Set last read for some participants ──
        $chat1LastMsg = Message::where('chat_id', $chat1->id)->latest()->first();
        if ($chat1LastMsg) {
            ChatParticipant::where('chat_id', $chat1->id)
                ->where('user_id', $user2->id)
                ->update(['last_read_message_id' => $chat1LastMsg->id]);
        }

        // ── Pin chat1 for user1 ──
        ChatParticipant::where('chat_id', $chat1->id)
            ->where('user_id', $user1->id)
            ->update(['is_pinned' => true]);

        // ── Mute group chat for user4 ──
        ChatParticipant::where('chat_id', $groupChat->id)
            ->where('user_id', $user4->id)
            ->update(['is_muted' => true]);

        $this->command->info('✅ Chat seeded: 2 individual chats, 1 group chat, ' . Message::count() . ' messages');
    }
}
