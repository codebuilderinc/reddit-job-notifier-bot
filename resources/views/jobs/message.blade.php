@extends('layouts.app')
@section('title', $job->post_title.' - '.config('app.name'))


@section('content')
<div class="container">
    <div class="row">
        <div class="" style="width: 100%; margin-top: 20px;">
            <form action="/job/message/{{$job->id}}" method="post">
                 {{ csrf_field() }}
                <div class="col justify-content-center" style="padding-left: 0px; padding-right: 0px; border-bottom: 0px; margin-bottom: 10px;">
                    <div class="card" style="min-width: 200px; width: 100%;">
                      <div class="card-body" style="padding-left: 0px; padding-right: 0px; padding-bottom: 0px;">

                        <h3 style="padding-left: 15px;">Job Posting</h3>
                        <hr>
                        <div style="padding: 1.25em; padding-top: 0px;">
                            {{$job->post_title}}
                            <hr>
                           <p class="card-text">
                               <a href="https://reddit.com/@php echo
htmlspecialchars_decode($job->href) @endphp"><strong>Reddit Post</strong></a>
                            </p>        
                            <p class="card-text">
                                @php echo
htmlspecialchars_decode($job->post_body) @endphp
                            </p>
                 
                        </div>
                        <h3 style="padding-left: 15px;">Send Message</h3>
                        <hr>
                        <div style="padding: 1.25em; padding-top: 0px;">
                            <input class="form-control" type="text" style="width: 100%; " placeholder="Enter a subject" value="Responding to [Hiring] on r/forhire" name="subject">
                            <hr>
                            <p class="card-text">
                                <textarea class="form-control" style="width: 100%; min-height: 320px;" placeholder="Please enter a message" name="message">Hey,

I'm writing in response to the job listing you posted on r/forhire.

A little bit about myself... I'm a full-stack developer from the United States, and I have over 15 years of coding experience. I have worked with clients such as the Department of Defense, Centers for Disease Control, United Nations, along with a myriad of other clients & projects throughout the years. You can find more information about my experience/portfolio on the following pages (replace {dot} with a .): 


* codebuilder {dot} us
* github {dot} com/digitalnomad91
* corbin {dot} world/resume


My pay rate start at $50 USD/hr, but that can go up or down depending on the exact type of work you require (Design & Planning, Front-End (UX), Back-End, Mobile Applications, Server Admin / DevOps, etc...). I am open to negotiation as well, depending on your desired delivery schedule, overall hours, and technical specifications. If you require more than a couple of days of work, I'd be happy to create a proposal for you. The proposal will outline developmental milestones, functionality requirements, roles & responsibilities, and a time & effort cost estimate. 

Let me know if you'd like to chat more. I'm available via the following platforms (replace {dot} with a .):

* Google (andrew {at} codebuilder {dot} us)
* Skype (live:.cid.b8641dfacb2f9cb8 )
* Discord (digitalnomad91#3044)
* IRC (subtlefu {dot} ge/root - Web Chat: subtlefu {dot} ge/irc)
* telephone (+1 305 801 2674)
* Matrix (https://matrix.to/#/#codebuilder_support:subtlefu{dot}ge)
* Telegram (+1 305 801 2674)

If you have questions, please message me on any of the above services, or let me know if you have another preference for getting in touch.

Best Regards,                                                                      


Andrew Corbin</textarea>
                            </p>
                        </div>
                        <div class="container" style="position: fixed; bottom: 42px;">
                            <div class="row">
                                <div class="col" style="padding-left: 0px; padding-right: 0px;">
                                    <a style="width: 100%; border-top-right-radius: 0px;  border-bottom-right-radius: 0px; border-top-left-radius: 0px;  border-bottom-left-radius: 0px;" href="#" class="btn btn-danger"><i class="fas fa-trash"></i> Reject </a>
                                </div>
                                <div class="col" style="padding-left: 0px; padding-right: 0px;">
                                    <button type="submit" style="width: 100%; border-top-right-radius: 0px;  border-bottom-right-radius: 0px;  border-top-left-radius: 0px;  border-bottom-left-radius: 0px;" class="btn btn-primary">Send Message <i class="fas fa-arrow-right"></i></button>
                                </div>
                            </div>
                        </div>
                      </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script type="text/javascript">
        $('textarea[name="message"]').height($(".main").height());
    </script>

</div>
@endsection
