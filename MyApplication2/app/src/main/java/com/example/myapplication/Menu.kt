package com.example.myapplication

import android.content.Intent
import android.os.Bundle
import androidx.appcompat.app.AppCompatActivity
import androidx.constraintlayout.widget.ConstraintLayout
import android.widget.Button
import androidx.activity.enableEdgeToEdge

class Menu : AppCompatActivity() {

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        enableEdgeToEdge()
        setContentView(R.layout.activity_menu)

        val btnCerrarSesion = findViewById<Button>(R.id.btnCerrarSesion)

        btnCerrarSesion.setOnClickListener {

            val intent = Intent(this, MainActivity::class.java)
            startActivity(intent)
        }

        val cardInventario = findViewById<ConstraintLayout>(R.id.cardInventario)

        cardInventario.setOnClickListener {

            val intent = Intent(this, Inventario::class.java)
            startActivity(intent)
        }

        val cardFinanzas = findViewById<ConstraintLayout>(R.id.cardFinanzas)

        cardFinanzas.setOnClickListener {

            val intent = Intent(this, Finanzas::class.java)
            startActivity(intent)
        }

    }
}