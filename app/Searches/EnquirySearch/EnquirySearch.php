<?php

namespace App\Searches\EnquirySearch;

use App\Models\Enquiry;
use App\Models\EnquiryType;
use App\Models\EnquiryStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EnquirySearch
{
    public static function apply(Request $filters)
    {
        /*
         * Create the base query of the enquiry with their phones, user types and user type statuses
         */
        $enquiryList = (new Enquiry)
            ->newQuery()
            ->orderBy('created_at', 'desc');
        $enquiryList->with('enquiryType')
            ->with('enquiryStatus');
        Log::warning($enquiryList->get());
        //    ->with('EnquiryTypes.enquiryStatus');
        /*
         * If we have a request to filter by name apply that filter
         */
        if ($filters->nameQuery !== null) {
            $enquiryList->where('enquiries.name', 'LIKE', '%' . $filters->nameQuery . '%');
        }

        /*
         * The EnquiryType and enquiryStatuses can be queried separately or together eg -
         *  We might want all users with 'active' and/or 'inactive' roles, no matter what role it is
         *  We might want all users with specific role(s) whether it is 'active' or 'inactive'
         *  We might want all user with specific roles whether active or inactive
         *
         */
        /*
* The EnquiryType and enquiryStatuses can be queried separately or together eg -
*  We might want all users with 'active' and/or 'inactive' roles, no matter what role it is
*  We might want all users with specific role(s) whether it is 'active' or 'inactive'
*  We might want all user with specific roles whether active or inactive
*
*/
        $flgEnquiryTypes = false;
        $flgEnquiryStatuses = false;
        if ($filters->enquiryTypeQuery !== null) {
            $enquiryTypes = explode(',', $filters->enquiryTypeQuery);
            $flgEnquiryTypes = true;
        }
        if ($filters->enquiryStatusQuery !== null) {
            $enquiryStatuses = explode(',', ($filters->enquiryStatusQuery));
            $flgEnquiryStatuses = true;
        }

        /*
         * Do we have a enquiryTypeQuery with a EnquiryTypeStatus query?
         */
        if ($flgEnquiryTypes && $flgEnquiryStatuses) {
            /*
             * If we have both a EnquiryType query and a enquiryStatus query then
             * we will filter the dataset at the userEnquiryType level selecting by the qualifying
             * EnquiryTypeId's and enquiryStatusId's
             *
             * First, take the array of User Types passed in the request and
             * create a corresponding array of enquiry_type_ids to filter the query by.
             */
            for ($i = 0; $i < count($enquiryTypes); $i++) {
                $enquiryTypeReturned = EnquiryType::where('enquiry_type', '=', $enquiryTypes[$i])->first();
                Log::warning($enquiryTypeReturned);
                $newEnquiryTypes[$i]['id'] = $enquiryTypeReturned->id;
                $newEnquiryTypes[$i]['desc'] = $enquiryTypes[$i];
            }
            /*
             * Repeat for the enquiryStatuses
             */
            for ($i = 0; $i < count($enquiryStatuses); $i++) {
                Log::warning("iteration " . $i);
                $enquiryStatusReturned = enquiryStatus::where('enquiry_status', '=', $enquiryStatuses[$i])->first();
                Log::warning($enquiryStatusReturned);
                $newEnquiryStatuses[$i]['id'] = $enquiryStatusReturned->id;
                $newEnquiryStatuses[$i]['desc'] = $enquiryStatuses[$i];
            }
            /*
             * Constrain the user records in the first instance to only those that have
             * EnquiryTypes in effect
             */
            $enquiryList->whereHas('enquiryType', function ($q) use ($newEnquiryTypes, $newEnquiryStatuses) {
                $firstQueryProcessed = false;
                /*
                 * Iterate each EnquiryType
                 */
                for ($i = 0; $i < count($newEnquiryTypes); $i++) {
                    /*
                     * And the enquiryStatuses
                     */
                    for ($j = 0; $j < count($newEnquiryStatuses); $j++) {
                        /*
                         * For the first item in the query pairings we want to create an 'and' condition
                         * in the query stack
                         */
                        if (!$firstQueryProcessed) {
                            $firstQueryProcessed = true;
                            $q->where(function ($q2) use ($i, $j, $newEnquiryTypes, $newEnquiryStatuses) {
                                $q2->where('enquiry_type_id', '=', $newEnquiryTypes[$i]['id']);
                                $q2->where('enquiry_status_id', '=', $newEnquiryStatuses[$j]['id']);
                            });
                            /*
                             * But for subsequent query pairings we require an 'or'
                             */
                        } else {
                            $q->orWhere(function ($q2) use ($i, $j, $newEnquiryTypes, $newEnquiryStatuses) {
                                $q2->where('enquiry_type_id', '=', $newEnquiryTypes[$i]['id']);
                                $q2->where('enquiry_status_id', '=', $newEnquiryStatuses[$j]['id']);
                            });
                        }
                    }
                }
            });
        } else
            if ($flgEnquiryTypes) {
                /* otherwise, we just have a EnquiryType filter and no statuses to worry about */
                $enquiryList->whereHas('enquiryType', function ($q) use ($enquiryList, $enquiryTypes, $filters) {
                    $blnFirstEnquiryTypeFound = false;
                    $queryArray = array();
                    for ($i = 0; $i < count($enquiryTypes); $i++) {
                        $queryArray [$i] = [
                            ['enquiry_types.enquiry_type', '=', $enquiryTypes[$i]],
                        ];
                        if (!$blnFirstEnquiryTypeFound) {
                            $blnFirstEnquiryTypeFound = true;
                            $q->where([$queryArray]);
                        } else {
                            $q->orWhere([$queryArray]);
                        }
                        $queryArray = array();
                    }
                });
            } else
                if ($flgEnquiryStatuses) {
                    /* otherwise, we just have a enquiryStatus filter and no EnquiryTypes to worry about */
                    if ($filters->enquiryStatusQuery !== null) {
                        $enquiryList->whereHas('enquiryStatus', function ($q) use ($enquiryList, $enquiryStatuses, $filters) {
                            $blnFirstEnquiryTypeFound = false;
                            $queryArray = array();
                            if (count($enquiryStatuses) > 0) {
                                for ($j = 0; $j < count($enquiryStatuses); $j++) {
                                    $queryArray [$j] = [
                                        ['enquiry_statuses.enquiry_status', '=', $enquiryStatuses[$j]]
                                    ];
                                    if (!$blnFirstEnquiryTypeFound) {
                                        $blnFirstEnquiryTypeFound = true;
                                        $q->where([$queryArray]);
                                    } else {
                                        $q->orWhere([$queryArray]);
                                    }
                                    $queryArray = array();

                                }
                            }
                        });
                    }
                }
        return $enquiryList;
    }


}
