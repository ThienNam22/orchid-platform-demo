<?php

namespace App\Orchid\Screens;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Alert;


class EmailSenderScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'ThienNam23 - Header';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'ThienNam23 - Description';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'subject' => date('F').' Campaign News',
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Send Message')
                ->icon('paper-plane')
                ->method('sendMessage')
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            Layout::rows([
                Input::make('subject')
                    ->title('Subject')
                    ->required()
                    ->placeholder('ThienNam23 - Input Placeholder')
                    ->help('ThienNam23 - Help for input'),

                Relation::make('users.')
                    ->title('Recipients') // Người nhận
                    ->multiple()
                    ->required()
                    ->placeholder('Email addresses')
                    ->help('Enter the users that you would like to send this message to.')
                    ->fromModel(User::class, 'name', 'email'),

                Quill::make('content')
                    ->title('Content')
                    ->required()
                    ->placeholder('Insert text here ...')
                    ->help('Add the content for the message tht you would like to send.')

            ])
        ];
    }

    /**
     * @param Request $request
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'subject' => 'required|min:6|max:50',
            'users' => 'required',
            'content' => 'required|min:10'
        ]);

        Mail::raw($request->get('content'), function (Message $message) use ($request) {
            $message->from('thiennam23.orchid@gmail.com');
            $message->subject($request->get('subject'));

            foreach ($request->get('users') as $email) {
                $message->to($email);
            }
        });

        Alert::info('Your email message has been sent successfully.');
    }

}
