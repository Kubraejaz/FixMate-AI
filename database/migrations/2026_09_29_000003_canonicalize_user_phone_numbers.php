<?php

use App\Services\OtpService;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Rewrite users.phone to the canonical E.164 form produced by
     * OtpService::normalizePhone().
     *
     * Earlier rows were stored exactly as the user typed them, so the same
     * person could be "03441234567" on one account and "+923187417012" on
     * another. Login matches on an exact string, so any other spelling of the
     * number failed to find the account.
     *
     * The unique index on phone makes the rewrite unsafe if two rows
     * canonicalise to the same value, so collisions abort the migration and
     * leave the table untouched.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('users', 'phone')) {
            return;
        }

        $rewrites = [];

        foreach (DB::table('users')->whereNotNull('phone')->where('phone', '!=', '')->get() as $user) {
            $canonical = OtpService::normalizePhone($user->phone);

            if ($canonical !== $user->phone) {
                $rewrites[$user->id] = $canonical;
            }
        }

        if ($rewrites === []) {
            return;
        }

        $collisions = DB::table('users')
            ->whereIn('phone', array_values($rewrites))
            ->whereNotIn('id', array_keys($rewrites))
            ->pluck('phone');

        if ($collisions->isNotEmpty()) {
            throw new RuntimeException(
                'Cannot canonicalise users.phone, these values are already taken: '
                .$collisions->implode(', ')
            );
        }

        foreach ($rewrites as $id => $canonical) {
            DB::table('users')->where('id', $id)->update(['phone' => $canonical]);
        }
    }

    public function down(): void
    {
        // The original formatting cannot be reconstructed, so this is a no-op.
    }
};
