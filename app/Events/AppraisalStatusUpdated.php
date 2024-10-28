<?

namespace App\Events;

use App\Models\Appraisal;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AppraisalStatusUpdated
{
    use Dispatchable, SerializesModels;

    public $appraisal;

    /**
     * Create a new event instance.
     */
    public function __construct(array $appraisal)
    {
        $this->appraisal = $appraisal;
    }
}


