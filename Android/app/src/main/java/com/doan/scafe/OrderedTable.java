package com.doan.scafe;

import android.app.ActivityOptions;
import android.app.AlertDialog;
import android.content.Context;
import android.content.Intent;
import android.os.Build;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.annotation.RequiresApi;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.recyclerview.widget.DividerItemDecoration;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import org.jetbrains.annotations.NotNull;

import java.util.ArrayList;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class OrderedTable  extends AppCompatActivity {
    static OrderedTableAdapter orderedTableAdapter;
    ArrayList<ProductInTable> products;
    static TextView invoice_code;
    static TextView txtTotalMoney;
    static TextView txtChooseVoucher;
    static TextView txtDiscount;
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.ordered_table_layout);
        AlertDialog alertDialog = new AlertDialog.Builder(OrderedTable.this).create();
        Toolbar toolbar = findViewById(R.id.toolBar5);
        setSupportActionBar(toolbar);
        getSupportActionBar().setDisplayShowTitleEnabled(false);

        Button btnPay = findViewById(R.id.btnPay);
        btnPay.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (GlobalVar.currentTotalPrice > 0) {
                    GlobalVar.sCafeFunctions.thanhToan(OrderedTable.this);
                }
                else {

                    alertDialog.setTitle("Lỗi");
                    alertDialog.setMessage("Đơn 0đ không thể thanh toán");
                    alertDialog.show();
                }


            }
        });
        TextView txtTableNameDisplay = findViewById(R.id.txtTableNameDisplay);
        txtChooseVoucher = findViewById(R.id.txtChooseVoucher);
        txtChooseVoucher.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(OrderedTable.this, DiscountActivity.class);
                startActivity(intent);

            }
        });
        txtTableNameDisplay.setText(GlobalVar.currentSystemTableName);
        invoice_code = findViewById(R.id.invoice_code);
        txtTotalMoney = findViewById(R.id.txtFinalPrice);
        txtDiscount = findViewById(R.id.txtDiscount);
        products = new ArrayList<>();
        orderedTableAdapter = new OrderedTableAdapter(OrderedTable.this, products);
        RecyclerView recyclerView = findViewById(R.id.orderedRecyclerView);
        LinearLayoutManager linearLayoutManager = new LinearLayoutManager(this);
        DividerItemDecoration dividerItemDecoration = new DividerItemDecoration(recyclerView.getContext(),
                linearLayoutManager.getOrientation());
        recyclerView.addItemDecoration(dividerItemDecoration);
        recyclerView.setAdapter(orderedTableAdapter);
        recyclerView.setLayoutManager(linearLayoutManager);

        resetTableDetail();

        GlobalVar.sCafeFunctions.getProductsInTable(products,orderedTableAdapter);
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        super.onCreateOptionsMenu(menu);
        getMenuInflater().inflate(R.menu.ordered_table_menu, menu);

        return super.onCreateOptionsMenu(menu);
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle item selection
        switch (item.getItemId()) {
            case R.id.addProduct:
                Intent intent = new Intent(OrderedTable.this, ChooseCategory.class);
                startActivity(intent);
                finish();
                return true;
            case R.id.cancelInvoice:
                GlobalVar.sCafeFunctions.sCafeHolderAPI.huyThucDon(GlobalVar.currentSystemInvoiceID).enqueue(new Callback<String>() {
                    @Override
                    public void onResponse(Call<String> call, Response<String> response) {
                        GlobalVar.sCafeFunctions.updateDataFromFragments();
                        finish();

                    }

                    @Override
                    public void onFailure(Call<String> call, Throwable t) {

                    }
                });
            default:
                return super.onOptionsItemSelected(item);
        }
    }

    @Override
    public void onBackPressed() {
        GlobalVar.sCafeFunctions.updateDataFromFragments();
        finish();
    }

    static void resetTableDetail(){

        GlobalVar.sCafeFunctions.getTableDetail(invoice_code,txtTotalMoney,txtChooseVoucher, txtDiscount );
    }

}


class OrderedTableAdapter extends RecyclerView.Adapter<OrderedTableAdapter.ViewHolder> {


    ArrayList<ProductInTable> products;
    LayoutInflater inflater;

    public OrderedTableAdapter(Context ctx, ArrayList<ProductInTable> products) {
        this.products = products;
        this.inflater = LayoutInflater.from(ctx);
    }


    @NonNull
    @NotNull
    @Override
    public ViewHolder onCreateViewHolder(@NonNull @NotNull ViewGroup parent, int viewType) {
        View view = inflater.inflate(R.layout.ordered_table_item, parent, false);
        return new ViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull @NotNull ViewHolder holder, int position) {
        holder.txtProductName.setText(products.get(position).product_name);
        holder.txtProductPrice.setText(String.valueOf(products.get(position).product_price));
        holder.txtAmount.setText("x" +String.valueOf(products.get(position).quantity));
        holder.txtProductTotalPrice.setText(String.valueOf(products.get(position).total_price) + "đ");
        holder.btnIncrease.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                GlobalVar.sCafeFunctions.increaseProduct(v.getContext(),products.get(position).product_id , products , OrderedTable.orderedTableAdapter,OrderedTable.invoice_code , OrderedTable.txtTotalMoney , OrderedTable.txtChooseVoucher , OrderedTable.txtDiscount);
            }
        });
        holder.btnDecrease.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                GlobalVar.sCafeFunctions.decreaseProduct(v.getContext(),products.get(position).product_id , products , OrderedTable.orderedTableAdapter,OrderedTable.invoice_code , OrderedTable.txtTotalMoney , OrderedTable.txtChooseVoucher , OrderedTable.txtDiscount);
            }
        });
        holder.btnDelete.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                GlobalVar.sCafeFunctions.deleteProduct(v.getContext(),products.get(position).product_id , products , OrderedTable.orderedTableAdapter,OrderedTable.invoice_code , OrderedTable.txtTotalMoney , OrderedTable.txtChooseVoucher , OrderedTable.txtDiscount);
            }
        });



    }

    @Override
    public int getItemCount() {
        return products.size();
    }


    public class ViewHolder extends RecyclerView.ViewHolder {
        TextView txtProductName;
        TextView txtProductPrice;
        TextView txtProductTotalPrice;
        TextView txtAmount;
        Button btnIncrease;
        Button btnDecrease;
        Button btnDelete;
        public ViewHolder(@NonNull View itemView) {
            super(itemView);
            txtProductName = itemView.findViewById(R.id.txtDiscountCode);
            txtProductPrice = itemView.findViewById(R.id.txtDiscountDes);
            txtProductTotalPrice = itemView.findViewById(R.id.txtProductTotalPrice);
            txtAmount = itemView.findViewById(R.id.txtAmount);
            btnIncrease = itemView.findViewById(R.id.btnIncrease);
            btnDecrease = itemView.findViewById(R.id.btnDecrease);
            btnDelete = itemView.findViewById(R.id.btnDelete);
        }
    }
}
