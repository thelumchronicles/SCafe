package com.doan.scafe;

import android.app.Activity;
import android.content.Context;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.DividerItemDecoration;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;


import org.jetbrains.annotations.NotNull;

import java.util.ArrayList;

public class DiscountActivity extends AppCompatActivity {
    static ArrayList<Discount> discounts;
    static DiscountAdapter discountAdapter;
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.discount_layout);
        discounts = new ArrayList<>();
        discountAdapter = new DiscountAdapter(DiscountActivity.this, discounts);
        RecyclerView recyclerView = findViewById(R.id.discountRecyclerView);
        LinearLayoutManager linearLayoutManager = new LinearLayoutManager(this);
        DividerItemDecoration dividerItemDecoration = new DividerItemDecoration(recyclerView.getContext(),
                linearLayoutManager.getOrientation());
        recyclerView.addItemDecoration(dividerItemDecoration);
        recyclerView.setAdapter(discountAdapter);
        recyclerView.setLayoutManager(linearLayoutManager);

        Button btnDone = findViewById(R.id.btnDone);
        btnDone.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });

        resetDiscountList();
        Button btnResetDiscount = findViewById(R.id.btnResetDiscount);
        btnResetDiscount.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                GlobalVar.sCafeFunctions.resetDiscount();
            }
        });
    }
    static void resetDiscountList(){
        GlobalVar.sCafeFunctions.getDiscounts(discounts,discountAdapter);
    }
}

class DiscountAdapter extends RecyclerView.Adapter<DiscountAdapter.ViewHolder> {


    ArrayList<Discount> discounts;
    LayoutInflater inflater;

    public DiscountAdapter(Context ctx, ArrayList<Discount> discounts) {
        this.discounts = discounts;
        this.inflater = LayoutInflater.from(ctx);
    }


    @NonNull
    @NotNull
    @Override
    public ViewHolder onCreateViewHolder(@NonNull @NotNull ViewGroup parent, int viewType) {
        View view = inflater.inflate(R.layout.discount_item, parent, false);
        return new ViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull @NotNull ViewHolder holder, int position) {
        holder.txtDiscountCode.setText(discounts.get(position).discount_code);
        holder.txtDiscountDes.setText(discounts.get(position).discount_des);
        holder.txtDiscountPercent.setText(discounts.get(position).discount_percent + "%");
        if (discounts.get(position).isSelected == 0){
            holder.selectStatus.setVisibility(View.GONE);
        }
        else {
            holder.selectStatus.setVisibility(View.VISIBLE);
        }
        holder.itemView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (discounts.get(position).isSelected != 1) {
                    GlobalVar.sCafeFunctions.setDiscount(discounts.get(position).discount_id  , discounts , DiscountActivity.discountAdapter);

                }

            }
        });



    }

    @Override
    public int getItemCount() {
        return discounts.size();
    }


    public class ViewHolder extends RecyclerView.ViewHolder {
        TextView txtDiscountPercent;
        TextView txtDiscountCode;
        TextView txtDiscountDes;
        TextView selectStatus;
        CheckBox checkBoxDiscount;
        public ViewHolder(@NonNull View itemView) {
            super(itemView);
            txtDiscountPercent = itemView.findViewById(R.id.txtDiscountPercent);
            txtDiscountCode = itemView.findViewById(R.id.txtDiscountCode);
            txtDiscountDes = itemView.findViewById(R.id.txtDiscountDes);
            selectStatus = itemView.findViewById(R.id.selectStatus);
        }
    }
}

