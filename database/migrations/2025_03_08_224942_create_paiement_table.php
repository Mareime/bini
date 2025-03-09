<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('paiement', function (Blueprint $table) {
            $table->id(); // Clé primaire auto-incrémentée
            $table->decimal('montant', 15, 2); // Montant du paiement
            $table->timestamp('date_paiement')->useCurrent(); // Date du paiement
            $table->enum('mode_paiement', ['carte', 'virement', 'cheque', 'espèces']); // Mode de paiement
            $table->enum('status', ['en attente', 'réussi', 'échoué']); // Statut du paiement
            $table->unsignedBigInteger('id_compte'); // Clé étrangère vers la table "comptes"
            $table->unsignedBigInteger('id_beneficiaire'); // Clé étrangère vers la table "beneficiaires"
            $table->string('motif_de_la_depence')->default('Motif non spécifié'); // Motif de la dépense
            $table->enum('impulsion', ['TVA', 'IMF', 'Loyer', 'Exonéré']); // Type d'impulsion
            $table->timestamps(); // Colonnes created_at et updated_at

            // Définir les clés étrangères
            $table->foreign('id_compte')->references('id')->on('compte')->onDelete('cascade');
            $table->foreign('id_beneficiaire')->references('id')->on('beneficiaire')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paiement', function (Blueprint $table) {
            // Supprimer les clés étrangères
            $table->dropForeign(['id_compte']);
            $table->dropForeign(['id_beneficiaire']);
        });

        Schema::dropIfExists('paiement');
    }
};
