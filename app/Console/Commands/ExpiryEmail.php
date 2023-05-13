<?php

namespace App\Console\Commands;

use App\Models\EmailTemplate;
use App\Models\UserDocument;
use App\Notifications\CommonNotification;
use Illuminate\Console\Command;

class ExpiryEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expiry:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check expiry date of the documents';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $documents = UserDocument::with('user','worker.workerContractor')->where('valid_between','!=','NULL')->get();
            // $contractorDocuments = ContractorDocument::with('user','contractor.architect')->where('valid_between','!=','NULL')->get();
            $template = EmailTemplate::where('slug', 'document-expire')->first();
            if (!is_null($template)) {
                $strReplace = [
                    '[APP_NAME]',
                    '[LOGIN]',
                    '[IMG]',
                    '[DOCUMENT]',
                    '[WORKER]',
                    '[CONTRACTOR]',
                    '[TIME_LEFT]'
                ];
                $current_date = date('Y-m-d');
                $current_date = date_create($current_date);
                foreach($documents as $document)
                {
                    $sendMail = false;
                    $dateTo = date_create($document->valid_between);
                    $interval = date_diff($current_date, $dateTo)->format('%m-%d');
                    $getdate  = explode('-', $interval);
                    $month = $getdate[0];
                    $days = $getdate[1];
                    $strReplaceWith = [
                        config('Qrtiger'),
                        route('login'),
                        asset('images/realtime-protection_hires.png'),
                        $document->document_name,
                        $document->user->first_name,
                        $document->worker->workerContractor->first_name,
                    ];
                    if ($days == 0 && ($month == 3 || $month == 1)) {
                        $sendMail = true;
                        $timeLeft = $month > 1 ? $month . ' months' : $month . ' month';
                        $strReplaceWith[] = $timeLeft;
                    } elseif ($month == 0 && ($days == 15 || $days == 8)) {
                        $sendMail = true;
                        $strReplaceWith[] = $days.' days';
                    }

                    if ($sendMail) {
                        $subject = str_replace($strReplace, $strReplaceWith, $template->subject);
                        $content = str_replace($strReplace, $strReplaceWith, $template->content);
                        $data = [
                            'subject' => $subject,
                            'content' => $content,
                        ];
                        $contractor = $document->worker->workerContractor;
                        if (!is_null($contractor) && !is_null($contractor->email)) {
                            $contractor->notify(new CommonNotification($data));
                        }
                    }
                }

                return Command::SUCCESS;
            }

            return Command::INVALID;
        } catch(\Exception $e) {
            return $e->getMessage();
        }
    }
}
